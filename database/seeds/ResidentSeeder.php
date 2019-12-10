<?php

use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Address::query()->chunk(1000, function ($addresses) {
            foreach ($addresses as $address) {
                factory(\App\Resident::class)->create([
                    'address_id' => $address->id,
                    'relation' => 'Primary',
                ]);

                $num = random_int(0, 2);
                for ($x = 0; $x <= $num; $x++) {
                    factory(\App\Resident::class)->create([
                        'address_id' => $address->id,
                    ]);
                }
            }
        });
    }
}
