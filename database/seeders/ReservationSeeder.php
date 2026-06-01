<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Seed the reservations table with sample data for testing.
     * Run with: php artisan db:seed --class=ReservationSeeder
     */
    public function run(): void
    {
        $samples = [
            [
                'full_name'        => 'Maria Santos',
                'email'            => 'maria@example.com',
                'phone'            => '09171234567',
                'reservation_date' => now()->addDays(2)->toDateString(),
                'reservation_time' => '18:00',
                'party_size'       => 4,
                'purpose'          => 'Birthday Celebration',
                'status'           => 'confirmed',
                'notes'            => 'Please prepare a surprise cake.',
            ],
            [
                'full_name'        => 'Jose Reyes',
                'email'            => 'jose@example.com',
                'phone'            => '09189876543',
                'reservation_date' => now()->addDays(5)->toDateString(),
                'reservation_time' => '12:00',
                'party_size'       => 2,
                'purpose'          => 'Business Lunch',
                'status'           => 'pending',
                'notes'            => null,
            ],
            [
                'full_name'        => 'Anna Cruz',
                'email'            => 'anna.cruz@gmail.com',
                'phone'            => null,
                'reservation_date' => now()->addDays(10)->toDateString(),
                'reservation_time' => '19:30',
                'party_size'       => 6,
                'purpose'          => 'Anniversary Dinner',
                'status'           => 'pending',
                'notes'            => 'Window seat preferred.',
            ],
            [
                'full_name'        => 'Carlo Mendoza',
                'email'            => 'carlo@example.com',
                'phone'            => '09155556789',
                'reservation_date' => now()->subDays(1)->toDateString(),
                'reservation_time' => '10:00',
                'party_size'       => 10,
                'purpose'          => 'Team Meeting',
                'status'           => 'cancelled',
                'notes'            => 'Cancelled due to schedule conflict.',
            ],
            [
                'full_name'        => 'Liza Flores',
                'email'            => 'liza.flores@yahoo.com',
                'phone'            => '09201112222',
                'reservation_date' => now()->addDays(7)->toDateString(),
                'reservation_time' => '14:00',
                'party_size'       => 3,
                'purpose'          => 'Baby Shower',
                'status'           => 'confirmed',
                'notes'            => 'Pink and white decorations please.',
            ],
        ];

        foreach ($samples as $sample) {
            Reservation::create($sample);
        }

        $this->command->info('✅ Sample reservations seeded successfully!');
    }
}