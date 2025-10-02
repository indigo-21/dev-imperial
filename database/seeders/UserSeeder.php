<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            [
                'firstname'    => 'Admin',
                'lastname'     => 'Indigo 21',
                'user_type_id' => 1,
                'email'        => 'support@indigo21.com',
                'password'     => Hash::make('indigo21')
            ],

        ];

        User::insert($data);
    }
}
