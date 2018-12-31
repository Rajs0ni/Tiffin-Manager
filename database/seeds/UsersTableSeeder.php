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
        DB::table('users')->insert([
            'name' => 'Raj',
            'mobile' => '1234567890',
            'location' => 'Bhilwara',
            'is_provider' => 1,
            'otp' => 1234
        ]);
    }
}
