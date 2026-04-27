<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Direksi
        User::factory()->create([
            'name' => 'Bp. Satya Setiawan',
            'email' => 'dirut@satset.com',
            'password' => Hash::make('password'),
            'role' => 'direksi',
            'position' => 'Direktur Utama',
        ]);

        User::factory()->create([
            'name' => 'Ibu Merah Putih',
            'email' => 'sdm@satset.com',
            'password' => Hash::make('password'),
            'role' => 'direksi',
            'position' => 'Dir SDM & Legal',
        ]);

        User::factory()->create([
            'name' => 'Bp. Tegas Operasional',
            'email' => 'ops@satset.com',
            'password' => Hash::make('password'),
            'role' => 'direksi',
            'position' => 'Dir Operasional',
        ]);

        // Finance Admin
        User::factory()->create([
            'name' => 'Siti Finance',
            'email' => 'finance@satset.com',
            'password' => Hash::make('password'),
            'role' => 'finance',
        ]);

        // General Manager (GM)
        $gm = User::factory()->create([
            'name' => 'Pak GM Bangunan',
            'email' => 'gm@satset.com',
            'password' => Hash::make('password'),
            'role' => 'gm',
            'business_line' => 'Bangunan',
        ]);

        // Manager Area
        $manager = User::factory()->create([
            'name' => 'Bambang Manager',
            'email' => 'manager@satset.com',
            'password' => Hash::make('password'),
            'role' => 'manager_area',
            'area' => 'Semarang',
            'business_line' => 'Bangunan',
            'kpi_points' => 850,
        ]);

        // Korlap
        $korlap = User::factory()->create([
            'name' => 'Budi Korlap',
            'email' => 'korlap@satset.com',
            'password' => Hash::make('password'),
            'role' => 'korlap',
            'phone' => '08123456789',
            'area' => 'Semarang',
            'business_line' => 'Bangunan',
            'kpi_points' => 920,
        ]);

        // Subordinates (Anak Buah)
        $subordinates = [
            ['name' => 'Agus Tenaga Kerja', 'email' => 'agus@satset.com'],
            ['name' => 'Iwan Bengkel', 'email' => 'iwan@satset.com'],
            ['name' => 'Slamet Entertainment', 'email' => 'slamet@satset.com'],
        ];

        foreach ($subordinates as $sub) {
            User::factory()->create([
                'name' => $sub['name'],
                'email' => $sub['email'],
                'password' => Hash::make('password'),
                'role' => 'worker',
                'area' => 'Semarang',
            ]);
        }

        // Seed Projects
        \DB::table('projects')->insert([
            [
                'name' => 'Renovasi Ruko Pemuda',
                'client_name' => 'PT. Maju Jaya',
                'service_type' => 'Bangunan',
                'contract_value' => 75000000,
                'duration' => '2 Bulan',
                'area' => 'Semarang',
                'manager_id' => $manager->id,
                'created_at' => now(),
            ],
            [
                'name' => 'Instalasi TV Kabel Cluster A',
                'client_name' => 'Warga Cluster A',
                'service_type' => 'Entertainment',
                'contract_value' => 15000000,
                'duration' => '1 Minggu',
                'area' => 'Semarang',
                'manager_id' => $manager->id,
                'created_at' => now(),
            ],
        ]);

        // Directors
        \DB::table('directors')->insert([
            [
                'name' => 'Bp. Satya Setiawan',
                'position' => 'Direktur Utama',
                'bio' => 'Visi SatSet untuk Indonesia Maju.',
                'photo' => 'https://ui-avatars.com/api/?name=Satya+Setiawan&background=0D8ABC&color=fff',
            ],
            [
                'name' => 'Ibu Merah Putih',
                'position' => 'Direktur Operasional',
                'bio' => 'Mengutamakan kecepatan dan ketepatan.',
                'photo' => 'https://ui-avatars.com/api/?name=Merah+Putih&background=d32f2f&color=fff',
            ],
        ]);

        // Sample Salary for Korlap
        \DB::table('salaries')->insert([
            'user_id' => $korlap->id,
            'amount' => 5000000,
            'type' => 'gaji',
            'status' => 'paid',
            'payment_date' => now()->subDays(2),
        ]);
        
        \DB::table('salaries')->insert([
            'user_id' => $korlap->id,
            'amount' => 1250000,
            'type' => 'bagi_hasil',
            'status' => 'paid',
            'payment_date' => now()->subDays(1),
        ]);
        // Seed Badges
        $badges = [
            ['name' => 'Korlap Baja', 'icon' => 'fa-shield-halved', 'color' => '#f43f5e', 'description' => 'Konsistensi tinggi selama 3 bulan', 'requirement_type' => 'consistency', 'requirement_value' => 90],
            ['name' => 'Zero Complain', 'icon' => 'fa-check-double', 'color' => '#10b981', 'description' => 'Tidak ada keluhan dari klien', 'requirement_type' => 'complaint', 'requirement_value' => 0],
            ['name' => 'Revenue King', 'icon' => 'fa-crown', 'color' => '#fbbf24', 'description' => 'Mencapai target pendapatan area', 'requirement_type' => 'revenue', 'requirement_value' => 100000000],
            ['name' => 'Early Bird', 'icon' => 'fa-sun', 'color' => '#0ea5e9', 'description' => 'Selalu kirim laporan sebelum jam 17.00', 'requirement_type' => 'punctuality', 'requirement_value' => 100],
        ];

        foreach ($badges as $badge) {
            \DB::table('badges')->insert(array_merge($badge, ['created_at' => now(), 'updated_at' => now()]));
        }

        // Award some badges
        $allBadges = \DB::table('badges')->get();
        \DB::table('user_badges')->insert([
            ['user_id' => $korlap->id, 'badge_id' => $allBadges[0]->id, 'awarded_at' => now()],
            ['user_id' => $korlap->id, 'badge_id' => $allBadges[1]->id, 'awarded_at' => now()],
            ['user_id' => $manager->id, 'badge_id' => $allBadges[2]->id, 'awarded_at' => now()],
        ]);

        // Seed KPI Logs
        \DB::table('kpi_logs')->insert([
            ['user_id' => $korlap->id, 'points_change' => 50, 'reason' => 'Laporan tepat waktu 5 hari berturut-turut', 'category' => 'Punctuality', 'created_at' => now()],
            ['user_id' => $korlap->id, 'points_change' => 100, 'reason' => 'Bonus target progres mingguan', 'category' => 'Performance', 'created_at' => now()],
            ['user_id' => $korlap->id, 'points_change' => -10, 'reason' => 'Laporan terlambat 1 jam', 'category' => 'Punctuality', 'created_at' => now()->subDay()],
        ]);
    }
}
