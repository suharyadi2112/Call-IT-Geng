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
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name' => 'testing callit',
            'email' => 'test@gmail.com',
            'handphone' => '082283778944',
            'jabatan' => 'Perawat',
            'status' => '-',
            'divisi' => 'Kesehatan',
            'password' =>  Hash::make('12345678'),
        ]);
    }
}
