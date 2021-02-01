<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        App\Role::create([
            'roleName' => 'Client'
        ]);

        App\Role::create([
            'roleName' => 'Agent'
        ]);

        App\Role::create([
            'roleName' => 'Patron'
        ]);

        App\Role::create([
            'roleName' => 'Secretaire'
        ]);
    }
}
