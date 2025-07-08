<?php

namespace Database\Seeders;

use App\Models\ReservationAvailability;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workingHours = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
        $availabilityData = [];

        
        for ($i = 1; $i <= 30; $i++) {
            $date = Carbon::now()->addDays($i);
            $dateString = $date->format('Y-m-d');

            foreach ($workingHours as $time) {
                
                if ($date->isWeekend()) {
                    $availabilityData[$dateString][$time] = [
                        'is_available' => false,
                        'reason' => 'Weekend closure',
                    ];
                } else {
                    $availabilityData[$dateString][$time] = [
                        'is_available' => true,
                        'reason' => null,
                    ];
                }
            }
        }

        
        
        $weekdays = array_filter(array_keys($availabilityData), function ($dateString) {
            
            
            foreach($this->availabilityData[$dateString] ?? [] as $details) {
                if($details['is_available']) return true;
            }
            return false;
        });

        
        $daysToBlockCount = floor(count($weekdays) * 0.1);
        if ($daysToBlockCount > 0) {
            $daysToBlock = (array) fake()->randomElements($weekdays, $daysToBlockCount);

            foreach ($daysToBlock as $dateString) {
                $blockedSlots = (array) fake()->randomElements($workingHours, rand(1, 3));
                foreach ($blockedSlots as $time) {
                    $availabilityData[$dateString][$time] = [
                        'is_available' => false,
                        'reason' => fake()->randomElement([
                            'Equipment maintenance',
                            'Staff training',
                            'Holiday closure',
                            'Special event',
                        ]),
                    ];
                }
            }
        }


        
        
        $date5 = Carbon::now()->addDays(5)->format('Y-m-d');
        $availabilityData[$date5]['12:00'] = [
            'is_available' => false,
            'reason' => 'Lunch break extended for staff meeting',
        ];

        $date10 = Carbon::now()->addDays(10)->format('Y-m-d');
        $availabilityData[$date10]['10:00'] = [
            'is_available' => false,
            'reason' => 'Equipment maintenance scheduled',
        ];

        
        $recordsToInsert = [];
        $now = now();
        foreach ($availabilityData as $date => $times) {
            foreach ($times as $time => $details) {
                $recordsToInsert[] = [
                    'date' => $date,
                    'time' => $time,
                    'is_available' => $details['is_available'],
                    'reason' => $details['reason'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        
        foreach (array_chunk($recordsToInsert, 500) as $chunk) {
            ReservationAvailability::insert($chunk);
        }
    }
}
