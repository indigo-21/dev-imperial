<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 'id' => 1, 'name' => 'Admin'],
            [ 'id' => 2, 'name' => 'User']
        ];

        UserType::insert($data);
    }
}
