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
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'handphone' => '082283778944',
                'jabatan' => 'Administrator',
                'status' => 'Aktif',
                'divisi' => 'IT',
                'role' => 'Admin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'User Guest',
                'email' => 'user@gmail.com',
                'handphone' => '082283778944',
                'jabatan' => 'Guest',
                'status' => '-',
                'divisi' => '-',
                'role' => 'User',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Sandi',
                'email' => 'sandi@gmail.com',
                'handphone' => '082283778944',
                'jabatan' => 'IT Support',
                'status' => '-',
                'divisi' => 'IT',
                'role' => 'Worker',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Tommy',
                'email' => 'tommy@gmail.com',
                'handphone' => '082283778944',
                'jabatan' => 'IT Support',
                'status' => '-',
                'divisi' => 'IT',
                'role' => 'Worker',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Nindy',
                'email' => 'nindy@gmail.com',
                'handphone' => '082283778944',
                'jabatan' => 'IT Support',
                'status' => '-',
                'divisi' => 'IT',
                'role' => 'Worker',
                'password' => Hash::make('12345678'),
            ],
        ];
        
        foreach ($users as $userData) {
            \App\Models\User::create($userData);
        }


        $kategori =[
            [
                'nama' => 'Jaringan (Network)',
                'gambar' => 'kategori/jaringan.png'
            ],
            [
                'nama' => 'Perangkat Lunak (Software)',
                'gambar' => 'kategori/perangkat-lunak.png',
            ],
            [
                'nama' => 'Perangkat Keras (Hardware)',
                'gambar' => 'kategori/perangkat-keras.png',
            ],
            [
                'nama' => 'SIMRS',
                'gambar' => 'kategori/simrs.png',
            ],
            [
                'nama' => 'Printer & Scanner',
                'gambar' => 'kategori/printer-scanner.png',
            ],
            [
                'nama' => 'Dokumen & File',
                'gambar' => 'kategori/dokumen.png',
            ],
            [
                'nama' => 'Lainnya',
                'gambar' => 'kategori/lainnya.png',
            ]
        ];

        foreach ($kategori as $kategoriData) {
            \App\Models\KatPengaduan::create($kategoriData);
        }
        
    }
}
