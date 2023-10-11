<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        College::create(
            [
                'name' => 'IT Engeneering',
                'logo' => '/logo',
                'category_id' => '1',
            ]
        );
        College::create(
            [
                'name' => 'Dental',
                'logo' => '/logo',
                'category_id' => '2',
            ]
        );
    }
}