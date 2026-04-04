<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrafficReportSeeder extends Seeder
{
    public function run(): void
    {
        $issueTypes = [
            'traffic_signal_problem',
            'road_damage',
            'illegal_parking',
            'traffic_obstruction',
            'accident',
            'traffic_violation',
            'reckless_driving',
            'public_safety',
            'infrastructure',
        ];

       $locations = [
            ['name' => 'Cadulawan', 'lat' => 10.256627, 'lng' => 123.787488],
            ['name' => 'Calajo-an', 'lat' => 10.239883, 'lng' => 123.802493],
            ['name' => 'Camp 7', 'lat' => 10.316445, 'lng' => 123.772557],
            ['name' => 'Camp 8', 'lat' => 10.300968, 'lng' => 123.753957],
            ['name' => 'Cuanos', 'lat' => 10.288611, 'lng' => 123.795123],
            ['name' => 'Guindaruhan', 'lat' => 10.275713, 'lng' => 123.760850],
            ['name' => 'Linao', 'lat' => 10.258775, 'lng' => 123.812472],
            ['name' => 'Manduang', 'lat' => 10.291798, 'lng' => 123.778552],
            ['name' => 'Pakigne', 'lat' => 10.256846, 'lng' => 123.804970],
            ['name' => 'Poblacion Ward 1', 'lat' => 10.244626, 'lng' => 123.798018],
            ['name' => 'Poblacion Ward 2', 'lat' => 10.242911, 'lng' => 123.794816],
            ['name' => 'Poblacion Ward 3', 'lat' => 10.249107, 'lng' => 123.797297],
            ['name' => 'Poblacion Ward 4', 'lat' => 10.249491, 'lng' => 123.792287],
            ['name' => 'Tubod', 'lat' => 10.268499, 'lng' => 123.796361],
            ['name' => 'Tulay', 'lat' => 10.239558, 'lng' => 123.790497],
            ['name' => 'Tunghaan', 'lat' => 10.248564, 'lng' => 123.779759],
            ['name' => 'Tungkop', 'lat' => 10.235316, 'lng' => 123.783187],
            ['name' => 'Vito', 'lat' => 10.266827, 'lng' => 123.785829],
            ['name' => 'Tungkil', 'lat' => 10.243025, 'lng' => 123.813056],
        ];

        $citizenIds = [3, 7, 8];
        $enforcerIds = [2, 5, 6];

        $reports = [];

        // Generate 40 reports spread across last 3 months
        for ($i = 0; $i < 40; $i++) {
            $location = $locations[array_rand($locations)];
            $issueType = $issueTypes[array_rand($issueTypes)];
            $citizenId = $citizenIds[array_rand($citizenIds)];
            $enforcerId = $enforcerIds[array_rand($enforcerIds)];

            // Spread created_at across last 50 days
           $createdAt = Carbon::parse('2026-03-01')->addDays(rand(0, 34))->addHours(rand(0, 23))->addMinutes(rand(0, 59));
            // Assign status with weighted distribution
            $statusRoll = rand(1, 100);
            if ($statusRoll <= 20) {
                $status = 'pending';
                $verifiedBy = null;
                $verifiedAt = null;
                $assignedTo = null;
                $assignedAt = null;
                $resolvedAt = null;
            } elseif ($statusRoll <= 30) {
                $status = 'rejected';
                $verifiedBy = 4; // Head MITCOM
                $verifiedAt = (clone $createdAt)->addHours(rand(1, 5));
                $assignedTo = null;
                $assignedAt = null;
                $resolvedAt = null;
            } elseif ($statusRoll <= 45) {
                $status = 'verified';
                $verifiedBy = 4;
                $verifiedAt = (clone $createdAt)->addHours(rand(1, 5));
                $assignedTo = null;
                $assignedAt = null;
                $resolvedAt = null;
            } elseif ($statusRoll <= 65) {
                $status = 'assigned';
                $verifiedBy = 4;
                $verifiedAt = (clone $createdAt)->addHours(rand(1, 5));
                $assignedTo = $enforcerId;
                $assignedAt = (clone $createdAt)->addHours(rand(6, 12));
                $resolvedAt = null;
            } else {
                $status = 'resolved';
                $verifiedBy = 4;
                $verifiedAt = (clone $createdAt)->addHours(rand(1, 5));
                $assignedTo = $enforcerId;
                $assignedAt = (clone $createdAt)->addHours(rand(6, 12));
                $resolvedAt = (clone $createdAt)->addHours(rand(13, 48));
            }

            $reports[] = [
                'user_id' => $citizenId,
                'reporter_name' => null,
                'reporter_email' => null,
                'reporter_phone' => null,
                'issue_type' => $issueType,
                'description' => 'Seeded report: ' . str_replace('_', ' ', $issueType) . ' at ' . $location['name'] . '.',
                'location' => $location['name'],
                'latitude' => $location['lat'],
                'longitude' => $location['lng'],
                'status' => $status,
                'proof_image' => null,
                'resolved_at' => $resolvedAt,
                'image_path' => null,
                'verified_by' => $verifiedBy,
                'assigned_to' => $assignedTo,
                'assigned_at' => $assignedAt,
                'verified_at' => $verifiedAt,
                'created_at' => $createdAt,
                'updated_at' => $resolvedAt ?? $assignedAt ?? $verifiedAt ?? $createdAt,
            ];
        }

        DB::table('reports')->insert($reports);

        $this->command->info('40 seeded traffic reports inserted successfully.');
    }
}