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

            [
                'firstname'    => 'Danny',
                'lastname'     => 'Hakimi',
                'user_type_id' => 1,
                'email'        => 'danny@imperialfitout.co.uk',
                'password'     => Hash::make('danny123')
            ],

            [
                'firstname'    => 'Tommy',
                'lastname'     => 'Rae',
                'user_type_id' => 1,
                'email'        => 'tommy@imperialfitout.co.uk',
                'password'     => Hash::make('tommy123')
            ],

        ];

        User::insert($data);
    }
}
