<?php

use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Agency::create([
            'agencyName'    => 'Lumina Le Havre',
            'agencyAdr'     => 'Rue de la République',
            'agencyPhone'   => '0102030405',
            'agencyContact' => 'agence-lehavre@lumina.fr'
        ]);
    }
}
