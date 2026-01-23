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
                'business_name' => 'Thames Trading Ltd',
                'business_address' => '25 Canary Wharf, London E14 5AB, United Kingdom',
                'unique_tax_reference' => '12345 67890',
                'company_registration_number' => '08945612',
                'vat_number' => 'GB123456789',
                'client_type_id' => 1,
                'industry' => 'Wholesale & Trading',
            ],
            [
                'business_name' => 'GreenHaven Foods Ltd',
                'business_address' => 'Unit 4, Riverside Industrial Estate, Leeds LS10 1AB, United Kingdom',
                'unique_tax_reference' => '22345 98765',
                'company_registration_number' => '10233498',
                'vat_number' => 'GB987654321',
                'client_type_id' => 2,
                'industry' => 'Food Manufacturing',
            ],
            [
                'business_name' => 'NorthStar Digital Solutions Ltd',
                'business_address' => '3rd Floor, 14 King Street, Manchester M2 6AB, United Kingdom',
                'unique_tax_reference' => '33456 11223',
                'company_registration_number' => '07654321',
                'vat_number' => null,
                'client_type_id' => 1,
                'industry' => 'Information Technology',
            ],
            [
                'business_name' => 'BlueHarbour Logistics Ltd',
                'business_address' => 'Dock Office, Port of Felixstowe, Suffolk IP11 3SY, United Kingdom',
                'unique_tax_reference' => '44556 77889',
                'company_registration_number' => '06543219',
                'vat_number' => 'GB456789123',
                'client_type_id' => 1,
                'industry' => 'Logistics & Freight',
            ],
        ];

        foreach ($data as $item) {
            Client::updateOrCreate(
                ['business_name' => $item['business_name']],
                [
                    'business_address' => $item['business_address'],
                    'unique_tax_reference' => $item['unique_tax_reference'],
                    'company_registration_number' => $item['company_registration_number'],
                    'vat_number' => $item['vat_number'],
                    'client_type_id' => $item['client_type_id'],
                    'industry' => $item['industry'],
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}
