<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Job;
use App\Models\Training;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Demo Users ────────────────────────────────────────────────────────
        User::firstOrCreate(['email' => 'admin@pgrkam.gov.in'], [
            'name'       => 'PGRKAM Admin',
            'phone'      => '0172-2664001',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'district'   => 'Chandigarh',
            'is_active'  => true,
        ]);

        User::firstOrCreate(['email' => 'user@pgrkam.gov.in'], [
            'name'       => 'Harpreet Singh',
            'phone'      => '98765 43210',
            'password'   => Hash::make('password'),
            'role'       => 'user',
            'district'   => 'Ludhiana',
            'is_active'  => true,
        ]);

        // ── Services ──────────────────────────────────────────────────────────
        $services = [
            ['title' => 'Government Jobs',    'icon' => '🏛️', 'color' => 'blue',   'path' => '/jobs',               'sort_order' => 1],
            ['title' => 'Private Jobs',       'icon' => '🏢', 'color' => 'indigo', 'path' => '/jobs?type=private',  'sort_order' => 2],
            ['title' => 'Skill Training',     'icon' => '🎓', 'color' => 'green',  'path' => '/training',           'sort_order' => 3],
            ['title' => 'Resume Builder',     'icon' => '📄', 'color' => 'orange', 'path' => '/resume',             'sort_order' => 4],
            ['title' => 'Career Counselling', 'icon' => '💬', 'color' => 'purple', 'path' => '/counselling',        'sort_order' => 5],
            ['title' => 'Employment Schemes', 'icon' => '📋', 'color' => 'red',    'path' => '/services',           'sort_order' => 6],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['title' => $s['title']], array_merge($s, ['is_active' => true]));
        }

        // ── Sample Jobs ───────────────────────────────────────────────────────
        $jobs = [
            ['title' => 'Junior Clerk',          'department' => 'Revenue Dept.',        'location' => 'Chandigarh', 'type' => 'government', 'salary_range' => '₹25,000 – ₹35,000', 'application_deadline' => '2026-06-30'],
            ['title' => 'Software Developer',    'department' => 'Punjab IT Department',  'location' => 'Mohali',     'type' => 'government', 'salary_range' => '₹45,000 – ₹65,000', 'application_deadline' => '2026-07-15'],
            ['title' => 'Data Entry Operator',   'department' => 'Health Dept.',          'location' => 'Ludhiana',   'type' => 'government', 'salary_range' => '₹18,000 – ₹22,000', 'application_deadline' => '2026-06-20'],
            ['title' => 'Frontend Engineer',     'department' => 'TechCorp Pvt. Ltd.',    'location' => 'Mohali',     'type' => 'private',    'salary_range' => '₹40,000 – ₹70,000', 'application_deadline' => '2026-06-25'],
            ['title' => 'Customer Support Exec.','department' => 'BPO Solutions Ltd.',    'location' => 'Amritsar',   'type' => 'private',    'salary_range' => '₹15,000 – ₹25,000', 'application_deadline' => '2026-06-18'],
            ['title' => 'Electrician',           'department' => 'PSPCL',                 'location' => 'Patiala',    'type' => 'government', 'salary_range' => '₹20,000 – ₹30,000', 'application_deadline' => '2026-07-01'],
        ];

        foreach ($jobs as $j) {
            Job::firstOrCreate(['title' => $j['title'], 'department' => $j['department']], array_merge($j, ['is_active' => true]));
        }

        // ── Sample Trainings ──────────────────────────────────────────────────
        $trainings = [
            ['title' => 'Web Development Bootcamp',    'provider' => 'Punjab Skill Mission',  'category' => 'IT',           'duration' => '3 months', 'total_seats' => 30, 'fee' => 'Free'],
            ['title' => 'Electrician Trade Course',    'provider' => 'ITI Ludhiana',          'category' => 'Electrical',   'duration' => '6 months', 'total_seats' => 25, 'fee' => 'Free'],
            ['title' => 'Digital Marketing',           'provider' => 'CDAC Mohali',           'category' => 'Marketing',    'duration' => '2 months', 'total_seats' => 40, 'fee' => '₹500'],
            ['title' => 'Tailoring & Garment Making',  'provider' => 'Women Empowerment ITI', 'category' => 'Handcraft',    'duration' => '4 months', 'total_seats' => 20, 'fee' => 'Free'],
            ['title' => 'Spoken English & Soft Skills','provider' => 'PGRKAM Centre',         'category' => 'Communication','duration' => '1 month',  'total_seats' => 50, 'fee' => 'Free'],
        ];

        foreach ($trainings as $t) {
            Training::firstOrCreate(['title' => $t['title']], array_merge($t, ['is_active' => true]));
        }

        $this->command->info('✅ PGRKAM database seeded successfully!');
        $this->command->info('   Admin: admin@pgrkam.gov.in / password');
        $this->command->info('   User:  user@pgrkam.gov.in  / password');
    }
}
