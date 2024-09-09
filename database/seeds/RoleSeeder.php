<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'=>'Admin',
            'slug'=>'admin',
        ]);
        Role::create([
            'name'=>'Vendor',
            'slug'=>'vendor',
        ]);
        Role::create([
            'name'=>'User',
            'slug'=>'user',
        ]);
    }
}
