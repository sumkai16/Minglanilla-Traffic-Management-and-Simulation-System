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
                'description' => $this->generateDescription($issueType, $location['name']),
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
    private function generateDescription(string $issueType, string $locationName): string
{
    $templates = [
        'traffic_signal_problem' => [
            "Traffic light at $locationName is malfunctioning. Signal stuck on red for several minutes.",
            "Broken traffic signal near $locationName causing confusion among motorists.",
            "Traffic signal at $locationName not functioning properly since this morning.",
        ],
        'road_damage' => [
            "Large pothole along $locationName road causing damage to vehicles.",
            "Road surface at $locationName is severely cracked and needs immediate repair.",
            "Deep crater on the road near $locationName posing danger to motorcycles.",
        ],
        'illegal_parking' => [
            "Vehicles illegally parked along $locationName blocking one lane of traffic.",
            "Tricycles and motorcycles parked on the road shoulder at $locationName obstructing flow.",
            "Several vehicles blocking the road at $locationName with no parking signage observed.",
        ],
        'traffic_obstruction' => [
            "Road obstruction at $locationName due to construction materials left on the road.",
            "Fallen tree branch blocking part of the road near $locationName.",
            "Stalled vehicle at $locationName causing heavy traffic buildup.",
        ],
        'accident' => [
            "Minor collision between two motorcycles near $locationName. No serious injuries reported.",
            "Vehicle accident at $locationName involving a tricycle and a private car.",
            "Road accident near $locationName. Vehicles need to be cleared from the road.",
        ],
        'traffic_violation' => [
            "Motorists observed beating the red light repeatedly at $locationName.",
            "Truck violating load restriction ordinance along $locationName.",
            "Motorcycles riding against traffic direction near $locationName.",
        ],
        'reckless_driving' => [
            "Reckless driver spotted overtaking dangerously at $locationName.",
            "Motorcycle rider driving at high speed and weaving between vehicles near $locationName.",
            "Driver of a van observed swerving recklessly along $locationName road.",
        ],
        'public_safety' => [
            "Loose electrical wire hanging low over the road at $locationName.",
            "Open manhole near $locationName posing risk to pedestrians and cyclists.",
            "Flooding along $locationName making the road hazardous for motorists.",
        ],
        'infrastructure' => [
            "Damaged road barrier along $locationName needs immediate replacement.",
            "Missing road signs at the intersection near $locationName causing confusion.",
            "Broken street light at $locationName leaving the area dark at night.",
        ],
    ];

    $options = $templates[$issueType] ?? ["Incident reported at $locationName. Needs immediate attention."];
    return $options[array_rand($options)];
}
}
