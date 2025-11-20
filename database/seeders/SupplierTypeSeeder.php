<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SupplierType;

class SupplierTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
           ['name' => 'Asbestos'],
            ['name' => 'AV'],
            ['name' => 'Builder'],
            ['name' => 'Builders Work'],
            ['name' => 'Carpentry'],
            ['name' => 'Cleaning'],
            ['name' => 'Data'],
            ['name' => 'Decorator'],
            ['name' => 'Demolition'],
            ['name' => 'Design'],
            ['name' => 'Dry Lining'],
            ['name' => 'Electrical'],
            ['name' => 'Fire Safety'],
            ['name' => 'Flooring'],
            ['name' => 'Furniture'],
            ['name' => 'Glazed Partitioning'],
            ['name' => 'Health & Safety'],
            ['name' => 'Joiner'],
            ['name' => 'Labourer'],
            ['name' => 'Lighting'],
            ['name' => 'Mastic'],
            ['name' => 'Mechanical'],
            ['name' => 'Plumber'],
            ['name' => 'Security'],
            ['name' => 'Signage/Manifestation'],
            ['name' => 'Site Supervisor'],
            ['name' => 'Tiling'],
            ['name' => 'Waste Clearance'],
            ['name' => 'Building Control Inspector'],
        ];

        SupplierType::insert($data);
    }
}
