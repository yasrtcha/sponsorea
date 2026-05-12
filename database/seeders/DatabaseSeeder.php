<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Event;
use App\Models\SponsorOffer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@sponsorea.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Mahasiswa (Penyelenggara Event) - Fixed
        User::create([
            'name' => 'FORMAPI Universitas Brawijaya',
            'email' => 'mahasiswa@ub.ac.id',
            'password' => Hash::make('password'),
            'role' => 'Event',
            'verification_status' => 'pending',
            'verified_at' => now(),
        ]);

        // 3. Akun Perusahaan (Sponsor) - Fixed
        User::create([
            'name' => 'Wuffy Space Sawojajar',
            'email' => 'partnership@wuffyspace.com',
            'password' => Hash::make('password'),
            'role' => 'Company',
            'verification_status' => 'pending',
            'verified_at' => now(),
        ]);

        // 4. Menambah akun acak untuk testing verifikasi admin (Status: Menunggu)
        User::factory()->count(5)->create([
            'role' => 'Event',
            'verification_status' => 'pending',
        ]);

        User::factory()->count(3)->create([
            'role' => 'Company',
            'verification_status' => 'pending',
        ]);
    }
}
