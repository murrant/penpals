<?php

namespace App\Console\Commands;

use App\Address;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CleanZip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:zip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        foreach (Address::all() as $address) {
            $address->zip4 = Str::contains($address->zip4, '-')
                ? explode('-', $address->zip4)[1]
                : null;

            $address->save();
        }

        return 0;
    }
}
