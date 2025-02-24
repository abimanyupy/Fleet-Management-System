<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Gps;
use App\Models\User;
use App\Models\Trucks;
use App\Models\Drivers;
use App\Models\FuelLog;
use Illuminate\Support\Str;
use App\Models\HaulingRoutes;
use App\Models\TruckService;
use App\Models\TruckCondition;
use Illuminate\Database\Seeder;
use App\Models\TruckAssignments;
use App\Models\HaulingRouteWeather;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Abimanyu',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make("admin123"),
        ]);

        $faker=fake('id_ID');
            for ($i=0; $i < 10; $i++) {
                $dataDrivers[]=[
                    'id' => Str::uuid()->toString(),
                    'name' => $faker->name,
                    'email' => $faker->unique()->email,
                    'phone' => $faker->unique()->phoneNumber,
                    'license_number' => $faker->unique()->randomNumber(6),
                    'driver_status' => $faker->randomElement(['active', 'inactive']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        Drivers::insert($dataDrivers);

        $faker=fake('id_ID');
            for ($i=0; $i < 10; $i++) {
                $createdDate = now();
                $dataTrucks[]=[
                    'id' => Str::uuid()->toString(),
                    'number_plate' => $faker->unique()->randomNumber(6),
                    'truck_capacity' => $faker->randomNumber(2),
                    // 'hauling_max_speed' => $faker->randomNumber(2),
                    // 'empty_max_speed' => $faker->randomNumber(2),
                    'fuel_capacity' => $faker->randomNumber(2),
                    // 'fuel_consumption' => $faker->randomNumber(2),
                    'license_number' => $faker->unique()->randomNumber(6),
                    'created_date' => $createdDate,
                    'expired_date' => $createdDate->copy()->addDays(30),
                    'license_status' => $faker->randomElement(['active']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        Trucks::insert($dataTrucks);

        $faker=fake('id_ID');
            for ($i=0; $i < 5; $i++) {
                $service_date = Carbon::parse($faker->dateTimeBetween('-2 months', 'now'));
                $next_service_date = $service_date->copy()->addDays(30); // Tambah 30 hari ke depan

                // Hitung selisih hari antara next_service_date dan sekarang
                $days_until_next_service = now()->diffInDays($next_service_date, false);

                // Tentukan status berdasarkan selisih hari
                if ($days_until_next_service > 7) {
                    $service_status = 'READY';
                } else {
                    $service_status = 'NEED REPAIR';
                }
                $dataTruckServices[]=[
                    'id' => Str::uuid()->toString(),
                    'truck_id' => $dataTrucks[array_rand($dataTrucks)]['id'],
                    'service_description' => $faker->sentence,
                    'service_status' => $service_status,
                    'is_serviced' => true,
                    'start_service_date' => $service_date,
                    'next_service_date' => $service_date->copy()->addDays(30),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        TruckService::insert($dataTruckServices);

        $faker=fake('id_ID');
            for ($i=0; $i < 10; $i++) {
                $dataTrucksCondition[]=[
                    'id' => Str::uuid()->toString(),
                    'truck_id' => $dataTrucks[array_rand($dataTrucks)]['id'],
                    'damage_type' => $faker->sentence(),
                    'is_resolved' => true,
                    'record_at' => $faker->dateTimeBetween('-1 month', 'now'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        TruckCondition::insert($dataTrucksCondition);

        $faker=fake('id_ID');
            for ($i=0; $i < 10; $i++) {
                $price = '22000';
                $liter = $faker->randomNumber(2);
                $cost = $price * $liter;

                $dataFuelLogs[]=[
                    'id' => Str::uuid()->toString(),
                    'truck_id' => $dataTrucks[array_rand($dataTrucks)]['id'],
                    'driver_id' => $dataDrivers[array_rand($dataDrivers)]['id'],
                    'refuel_date' => $faker->dateTimeBetween('-1 month', 'now'),
                    'liters_filled' => $liter,
                    'cost' => $cost,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        FuelLog::insert($dataFuelLogs);

        $faker=fake('id_ID');
            for ($i=0; $i < 10; $i++) {
                $dataGps[]=[
                    'id' => Str::uuid()->toString(),
                    'truck_id' => $dataTrucks[array_rand($dataTrucks)]['id'],
                    'device_id' => $faker->unique()->randomNumber(6),
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        Gps::insert($dataGps);

        $faker=fake('id_ID');
            for ($i=0; $i < 1; $i++) {
                $dataHaulingRouter[]=[
                    'id' => Str::uuid()->toString(),
                    'route_name' => 'Hauling 1',
                    'length' => $faker->randomNumber(2),
                    'estimation_time' => $faker->time(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        HaulingRoutes::insert($dataHaulingRouter);

        $faker=fake('id_ID');
            for ($i=0; $i < 2; $i++) {
                $dataHaulingWeather[]=[
                    'id' => Str::uuid()->toString(),
                    'route_id' => $dataHaulingRouter[array_rand($dataHaulingRouter)]['id'],
                    'kilometer' => $faker->randomNumber(2),
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'weather_condition' => $faker->randomElement(['SUNNY', 'RAIN', 'SNOW', 'WIND', 'CLOUDY']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        HaulingRouteWeather::insert($dataHaulingWeather);

        $faker=fake('id_ID');
            for ($i=0; $i < 5; $i++) {
                $departureTime = $faker->time('H:i:s'); // Waktu random dalam format 24 jam
                $arrivalTime = Carbon::createFromFormat('H:i:s', $departureTime)
                                    ->addMinutes(rand(10, 180)) // Tambah 10-180 menit
                                    ->format('H:i:s');

                $cycleTime = Carbon::parse($departureTime)->diffInMinutes(Carbon::parse($arrivalTime));

                $dataTruckAssignments[]=[
                    'id' => Str::uuid()->toString(),
                    'driver_id' => $dataDrivers[array_rand($dataDrivers)]['id'],
                    'truck_id' => $dataTrucks[array_rand($dataTrucks)]['id'],
                    'hauling_route_id' => $dataHaulingRouter[array_rand($dataHaulingRouter)]['id'],
                    'assignment_date' => $faker->dateTimeBetween('-1 month', 'now'),
                    // 'deparature_time' => $departureTime,
                    'arrival_time' => $arrivalTime,
                    'cycle_time' => $cycleTime,
                    'assignment_status' => $faker->randomElement(['ON PROGRESS', 'COMPLETE', 'PENDING']),
                    'total_load' => $faker->randomNumber(2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        TruckAssignments::insert($dataTruckAssignments);
    }
}
