<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectType;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $data = [
            ['name' => 'CAT A'],
            ['name' => 'CAT A+'],
            ['name' => 'CAT B'],
            ['name' => 'Small Works'],
            ['name' => 'Refurbishment'],
            ['name' => 'Reconfiguration'],
            ['name' => 'Day 2 Works'],
            ['name' => 'Dilapidation'],
            ['name' => 'Design Only'],
            ['name' => 'Furniture Only'],
        ];

         ProjectType::insert($data);


        
    }
}
