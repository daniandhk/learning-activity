<?php

namespace Database\Seeders;

use App\Models\Method;
use App\Models\Month;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $january = Month::create([
            'number' => 1,
        ]);
        
        $february = Month::create([
            'number' => 2,
        ]);

        $march = Month::create([
            'number' => 3,
        ]);

        $april = Month::create([
            'number' => 4,
        ]);

        $may = Month::create([
            'number' => 5,
        ]);

        $june = Month::create([
            'number' => 6,
        ]);

        $method = Method::create([
            'name' => 'Workshop/ Self Learning',
        ]);

        Schedule::create([
            'method_id' => $method['id'],
            'name' => 'Basic Finance for Bussiness',
            'date_start' => '10/01/2022',
            'date_end' => '15/01/2022'
        ]);

        $method = Method::create([
            'name' => 'Sharing Practice/ Professional\'s Talk',
        ]);

        $method = Method::create([
            'name' => 'Discussion room',
        ]);

        $method = Method::create([
            'name' => 'Coaching',
        ]);

        $method = Method::create([
            'name' => 'Mentoring',
        ]);
    }
}
