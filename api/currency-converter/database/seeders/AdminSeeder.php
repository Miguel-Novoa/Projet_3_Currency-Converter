<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
        [
            [
              'name' => 'john',
              'password' => bcrypt('password'),
            ]
        ];

        foreach ($data as $userData) {
            User::create([
                'name' => $userData['name'],
                'password' => $userData['password'],
            ]);
        }
    }
}
