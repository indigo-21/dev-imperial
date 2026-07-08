<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'business_name' => 'Newforge Holdings Limited',
                'business_address' => "4th Floor, St Paul's Gate, 22-24 New Street, St Helier",
                'company_registration_number' => 'OE014985',
                'client_type_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Add additional clients here
            [
                'business_name' => 'Indigo 21',
                'business_address' => "4th Floor, St Paul's Gate, 22-24 New Street, St Helier",
                'company_registration_number' => 'OE014985',
                'client_type_id' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];


        Client::insert($data);
    }
}
