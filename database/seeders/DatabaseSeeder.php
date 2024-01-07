<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\ServiceSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('iniadmin');
        $password2 = bcrypt('inidokter');
        $password3 = bcrypt('inipasien');

        // admin default
        User::create([
            'name' => 'Admin',
            'email' => 'admin@rs.poli.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'is_active' => 1,
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        // dokter default
        User::create([
            'name' => 'Dokter',
            'email' => 'fitridoctor@rs.poli.com',
            'email_verified_at' => now(),
            'role' => 'doctor',
            'is_active' => 1,
            'password' => $password2,
            'remember_token' => Str::random(10),
        ]);

        // pasien default
        User::create([
            'name' => 'Pasien',
            'email' => 'fitritest@gmail.com',
            'email_verified_at' => now(),
            'role' => 'guest',
            'is_active' => 1,
            'password' => $password3,
            'remember_token' => Str::random(10),
        ]);

        Poli::create([
            'name' => 'Umum',
            'description' => 'Poli Umum',
        ]);

        Poli::create([
            'name' => 'Gigi',
            'description' => 'Melayani pasien gigi',
        ]);

        Poli::create([
            'name' => 'KIA',
            'description' => 'Melayani pasien KIA',
        ]);

        Poli::create([
            'name' => 'Mata',
            'description' => 'Melayani pasien mata',
        ]);

        Doctor::create([
            'user_id' => 2,
            'poli_id' => 1,
            'name' => 'Dokter',
            'address' => 'Jl. Admin',
            'phone_number' => '081234567890',
        ]);

        Patient::create([
            'user_id' => 3,
            'name' => 'Pasien 1',
            'ktp_number' => '1234567890123456',
            'rm_number' => '2101-001',
            'phone_number' => '081234567890',
            'address' => 'Jl. Pasien 1',
        ]);

        ServiceSchedule::create([
            'doctor_id' => 1,
            'day' => 1,
            'start_time' => '08:00',
            'end_time' => '12:00',
            'is_active' => 1,
        ]);

        Drug::create([
            'code' => '0001',
            'name' => 'Paracetamol',
            'packaging' => '10',
            'price' => '10000',
            'stock' => '100',
        ]);

        Drug::create([
            'code' => '0002',
            'name' => 'Amoxilin',
            'packaging' => '10',
            'price' => '20000',
            'stock' => '100',
        ]);

        Drug::create([
            'code' => '0003',
            'name' => 'Antimo',
            'packaging' => '10',
            'price' => '30000',
            'stock' => '100',
        ]);

        Drug::create([
            'code' => '0004',
            'name' => 'Antalgin',
            'packaging' => '10',
            'price' => '40000',
            'stock' => '100',
        ]);
    }
}
