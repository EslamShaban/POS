<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'f_name' => 'super',
            'l_name' => 'admin',
            'email' => 'superadmin@app.com',
            'password' => bcrypt('123456')
        ]);

        $user->attachRole('super_admin');
    }
}
