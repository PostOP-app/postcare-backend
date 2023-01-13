<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name' => 'PostCare',
            'last_name' => 'Admin',
            'email' => 'admin@web3.com',
            'password' => Hash::make('password'),
        ]);

        $patient = User::create([
            'first_name' => 'PostCare',
            'last_name' => 'Patient',
            'email' => 'patient@web3.com',
            'password' => Hash::make('password'),
        ]);

        $provider = User::create([
            'first_name' => 'PostCare',
            'last_name' => 'Provider',
            'email' => 'provider@web3.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('Admin');
        $patient->assignRole('Patients');
        $provider->assignRole('Providers');
    }
}