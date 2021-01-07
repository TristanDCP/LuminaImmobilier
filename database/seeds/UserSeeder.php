<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'userLastname'  => 'John',
            'userFirstname' => 'Saucisse',
            'userEmail'     => 'client1@lumina.fr',
            'userDob'       => '1990-01-01',
            'userPhone'     => '0102030405',
            'userAdr'       => '1 rue de truc',
            'userPassword'  => Hash::make('dflbog'),
            'idRole'        => '1',
            'idAgency'      => '1'
        ]);

        App\User::create([
            'userLastname'  => 'Bassem',
            'userFirstname' => 'Taboulé',
            'userEmail'     => 'client2@lumina.fr',
            'userDob'       => '1990-01-01',
            'userPhone'     => '0102030405',
            'userAdr'       => '1 rue de truc',
            'userPassword'  => Hash::make('dflbog'),
            'idRole'        => '1',
            'idAgency'      => '1'
        ]);

        App\User::create([
            'userLastname'  => 'Mohammed',
            'userFirstname' => 'Couscous',
            'userEmail'     => 'client3@lumina.fr',
            'userDob'       => '1990-01-01',
            'userPhone'     => '0102030405',
            'userAdr'       => '1 rue de truc',
            'userPassword'  => Hash::make('dflbog'),
            'idRole'        => '1',
            'idAgency'      => '1'
        ]);

        App\User::create([
            'userLastname'  => 'Compte',
            'userFirstname' => 'Agent',
            'userEmail'     => 'agent@lumina.fr',
            'userDob'       => '1990-01-01',
            'userPhone'     => '0102030405',
            'userAdr'       => '1 rue de truc',
            'userPassword'  => Hash::make('dflbog'),
            'idRole'        => '2',
            'idAgency'      => '1'
        ]);

        App\User::create([
            'userLastname'  => 'Compte',
            'userFirstname' => 'Patron',
            'userEmail'     => 'patron@lumina.fr',
            'userDob'       => '1990-01-01',
            'userPhone'     => '0102030405',
            'userAdr'       => '1 rue de truc',
            'userPassword'  => Hash::make('dflbog'),
            'idRole'        => '3',
            'idAgency'      => '1'
        ]);

        App\User::create([
            'userLastname'  => 'Compte',
            'userFirstname' => 'Secretaire',
            'userEmail'     => 'secretaire@lumina.fr',
            'userDob'       => '1990-01-01',
            'userPhone'     => '0102030405',
            'userAdr'       => '1 rue de truc',
            'userPassword'  => Hash::make('dflbog'),
            'idRole'        => '4',
            'idAgency'      => '1'
        ]);
        
    }
}
