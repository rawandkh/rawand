<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'user_name' => 'admin12',
            'phone' => '0937884587',
        ]);
        // $user->assignRole('admin');


        $code = Str::random(8);
        $user->codes()->create([
            'code' => $code,
            'college_id' => '1'
        ])->assignRole('admin');
    }
}