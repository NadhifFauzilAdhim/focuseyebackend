<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Analytic;
use App\Models\CaptureHistory;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // specific real user names for demo
        $names = [
            'Alex Johnson', 'Sarah Smith', 'John Doe', 'Emily Davis', 
            'Michael Brown', 'Jessica Wilson', 'David Taylor', 'Linda Moore'
        ];

        foreach ($names as $name) {
            $username = strtolower(str_replace(' ', '', $name)) . rand(10, 99);
            
            // Create Student
            $student = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $username . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                // Using UI Avatars for consistent pretty avatars
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=fff&size=200',
            ]);

            // Create some past analytics
            Analytic::create([
                'user_id' => $student->id,
                'duration' => 3600, // 1 hour
                'focus_duration' => rand(1800, 3500),
                'unfocus_duration' => rand(100, 1800),
                'start_time' => now()->subDays(rand(1, 5)),
                'end_time' => now()->subDays(rand(1, 5))->addHour(),
                'created_at' => now()->subDays(rand(1, 5)),
            ]);

            // Create a "Live" session (Analytic created today)
            $isFocused = rand(0, 10) > 3; // 70% chance focused
            $duration = rand(600, 3600);
            $focusDuration = $isFocused ? round($duration * (rand(70, 99) / 100)) : round($duration * (rand(10, 40) / 100));

            $analytic = Analytic::create([
                'user_id' => $student->id,
                'duration' => $duration,
                'focus_duration' => $focusDuration,
                'unfocus_duration' => $duration - $focusDuration,
                'start_time' => now()->subMinutes(rand(10, 60)),
                'end_time' => null, // Still active theoretically, or just recently finished
                'created_at' => now(), // Today
            ]);

            // Create Capture History for the live session with mock image paths (just to prevent errors, actual images won't exist on disk)
            // But our component uses the avatar if image_path is null or fails to load, so let's leave image_path null or use a placeholder URL if the DB column supports it.
            // Looking at migration: table->string('image_path')->nullable(); 
            // We won't put a path that doesn't exist.
            
            CaptureHistory::create([
                'analytic_id' => $analytic->id,
                'capture_time' => now(),
                'image_path' => null, // Will fallback to avatar
            ]);
        }
    }
}
