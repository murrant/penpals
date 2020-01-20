<?php

namespace App\Data;

use App\Address;
use App\AddressStatus;
use App\Exceptions\AddressParsingException;
use App\Resident;
use Exception;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class VoteBuilder
{
    protected $pdfFile;
    protected $txtFile;
    protected $people = [];
    public $pending = [];
    public $current = 0;
    private $fileHandle;

    public function __construct($pdfFile)
    {
        $this->pdfFile = $pdfFile;
    }

    public function clean()
    {
        $convertProc = new Process(['pdftotext', $this->pdfFile]);
        $convertProc->run();


        // deletes id line too
        $cleanQuestionsProc = new Process(['sed', '-i', '/·/,/\f/d', $this->txtFile()]);
        $cleanQuestionsProc->run();

        $cleanCheckboxesProc = new Process(['sed', '-i', 's/❏//', $this->txtFile()]);
        $cleanCheckboxesProc->run();

        $removeVoterIDProc = new Process(['sed', '-i', '/^[0-9][0-9]*$/d', $this->txtFile()]);
        $removeVoterIDProc->run();

        $removeEmptyLinesProc = new Process(['sed', '-i', '/^\s*$/d', $this->txtFile()]);
        $removeEmptyLinesProc->run();

        return $this;
    }

    /**
     *
     * @throws AddressParsingException
     */
    public function load()
    {
        $this->fileHandle = fopen($this->txtFile(), 'r');

        while (($line = fgets($this->fileHandle)) !== false) {
            $line = trim($line);
            if (!empty($line)) {
                $this->parseLine($line);
            }

            if (isset($this->pending[$this->current]) && $this->isValid($this->pending[$this->current])) {
                $this->people[] = $this->pending[$this->current];

                // remove and reset current
                unset($this->pending[$this->current]);
                $this->pending = array_values($this->pending);
                if (!isset($this->pending[$this->current]) && $this->current > 0) {
                    $this->current--;
                }
            }
        }

        fclose($this->fileHandle);

        return $this;
    }

    public function import()
    {
        foreach ($this->people as $person) {
            $address = Address::firstOrNew([
                'zip' => $person['zip'],
                'address' => $person['address'],
            ], [
                'city' => $person['city'],
                'state' => $person['state'],
                'address_number' => '',
                'street' => '',
                'county' => '',
            ]);

            $address->status = AddressStatus::Valid;
            $address->save();

            $address->residents()->save(new Resident([
                'name' => $person['first_name'] . ' ' . $person['last_name'],
                'first_name' => $person['first_name'],
                'last_name' => $person['last_name'],
                'age_range' => $person['age'],
                'gender' => $person['gender'],
            ]));
        }
    }

    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Sorry this is spaghetti
     * Columns are stacked one after the other and sometimes the first name on a page gets wrapped to the end...
     *
     * @param $line
     * @throws AddressParsingException
     */
    private function parseLine($line)
    {
        if (Str::contains($line, 'Age: ')) {
            $this->pending[] = ['age' => explode('Age: ', $line, 2)[1]]; // new array
        } elseif (Str::startsWith($line, 'Gender: ')) {
            $this->pending[count($this->pending) - 1]['gender'] = substr($line, 8);
        } elseif (Str::startsWith($line, 'Email:')) {
            // ignore emails
            return;
        } elseif (preg_match('/@\S+\./', $line)) {
            // email
            return;
        } elseif (preg_match('/\d{3}-\d{4}$/', $line)) {
            // phone
            return;
        } elseif (!isset($this->pending[$this->current]['last_name'])) {
            if (!Str::contains($line, ', ')) {
                $this->setAddress($line);
                // name wrapped to end
                $this->current++;
                return;
            }

            $name = explode(', ', $line, 2);
            if (count($name) < 2) {
                throw new AddressParsingException('Failed to parse name', $this, $line);
            }
            $this->pending[$this->current]['first_name'] = $name[1];
            $this->pending[$this->current]['last_name'] = $name[0];
        } elseif (!isset($this->pending[$this->current]['address'])) {
            $this->setAddress($line);
        } else {
            throw new AddressParsingException('Unhandled line', $this, $line);
        }
    }

    private function isValid($person)
    {
        return isset($person['first_name'], $person['last_name'], $person['age'], $person['gender'], $person['address'], $person['city'], $person['state'], $person['zip']);
    }

    private function setAddress($address)
    {
        $locality = trim(fgets($this->fileHandle));
        $res = preg_match('/(.*) ([A-Z]{2}) (\d+)/', $locality, $matches);

        if (!$res) {
            throw new AddressParsingException("Locality parsing error", $this, "$address  $locality");
        }

        $this->pending[$this->current]['address'] = $address;
        $this->pending[$this->current]['city'] = $matches[1];
        $this->pending[$this->current]['state'] = $matches[2];
        $this->pending[$this->current]['zip'] = $matches[3];
    }

    private function txtFile()
    {
        return $this->txtFile ?? $this->txtFile = preg_replace('/.pdf$/', '.txt', $this->pdfFile);
    }
}
