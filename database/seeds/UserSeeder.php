<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'dispatcher', 'director'];
        foreach ($roles as $role){
            $item = \App\Role::create([
                'name' => $role
            ]);
            \App\User::create([
                'name' => $role,
                'email' => $role . '@site.com',
                'password' => \Illuminate\Support\Facades\Hash::make('12345'),
                'role_id' => $item->id
            ]);
        }


    }
}
