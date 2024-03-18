<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'handphone' => '082283778944',
            'jabatan' => 'Administrator',
            'status' => '-',
            'divisi' => 'IT',
            'password' =>  Hash::make('12345678'),
        ]);

        \App\Models\User::create([
            'name' => 'User Guest',
            'email' => 'user@gmail.com',
            'handphone' => '082283778944',
            'jabatan' => 'Guest',
            'status' => '-',
            'divisi' => '-',
            'password' =>  Hash::make('12345678'),
        ]);

        \App\Models\User::create([
            'name' => 'Sandi',
            'email' => 'sandi@gmail.com',
            'handphone' => '082283778944',
            'jabatan' => 'IT Support',
            'status' => '-',
            'divisi' => 'IT',
            'password' =>  Hash::make('12345678'),
        ]);

        \App\Models\User::create([
            'name' => 'Tommy',
            'email' => 'tommy@gmail.com',
            'handphone' => '082283778944',
            'jabatan' => 'IT Support',
            'status' => '-',
            'divisi' => 'IT',
            'password' =>  Hash::make('12345678'),
        ]);

        \App\Models\User::create([
            'name' => 'Nindy',
            'email' => 'nindy@gmail.com',
            'handphone' => '082283778944',
            'jabatan' => 'IT Support',
            'status' => '-',
            'divisi' => 'IT',
            'password' =>  Hash::make('12345678'),
        ]);

    }
}
