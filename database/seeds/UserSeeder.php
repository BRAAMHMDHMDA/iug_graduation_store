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
        \App\Models\User::create([
            'name' => 'Braa mh Hmda',
            'username' => 'braa',
            'email' => 'b@b.b',
            'phone' => '0599123456',
            'password' => bcrypt('000'),
        ]);
    }
}
