<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;

class FetchAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:addresses {state} {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch addresses from apis and populate them into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        // https://www.melissa.com/v2/lookups/addresssearch/?city=decorah&state=IA&fmt=json&id=

        $jar = new CookieJar();

        $client->request('GET', 'https://www.melissa.com/v2/lookups/addresssearch/', [
            'cookies' => $jar
        ]);


        $response = $client->request('GET', 'https://www.melissa.com/v2/lookups/addresssearch/', [
            'query' => [
                'city' => $this->argument('city'),
                'state' => $this->argument('state'),
                'fmt' => 'json',
                'id' => null,
            ],
            'cookies' => $jar,
        ]);


        $streets = json_decode($response->getBody(), true);

        dd($streets, $jar);
    }
}
