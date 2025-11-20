<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TemplateSection;


class TemplateSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       $data = [

                    ['section_code' => '1.00', 'section_name' => 'Design Fees'],
                    ['section_code' => '2.00', 'section_name' => 'Site Set Up and Administration'],
                    ['section_code' => '3.00', 'section_name' => 'External Fees and Charges'],
                    ['section_code' => '4.00', 'section_name' => 'CDM Principal Designer & Principal Contractor'],
                    ['section_code' => '5.00', 'section_name' => 'Deconstruct / Strip Out'],
                    ['section_code' => '6.00', 'section_name' => 'Subfloor'],
                    ['section_code' => '7.00', 'section_name' => 'Partitions'],
                    ['section_code' => '8.00', 'section_name' => 'Folding Wall'],
                    ['section_code' => '9.00', 'section_name' => 'Doors & Hardware'],
                    ['section_code' => '10.00', 'section_name' => 'Ceilings'],
                    ['section_code' => '11.00', 'section_name' => 'Small Power'],
                    ['section_code' => '12.00', 'section_name' => 'Lighting'],
                    ['section_code' => '13.00', 'section_name' => 'Fire and Emergency Systems'],
                    ['section_code' => '14.00', 'section_name' => 'Data and Telecommunications'],
                    ['section_code' => '15.00', 'section_name' => 'Security Installation'],
                    ['section_code' => '16.00', 'section_name' => 'Mechanical'],
                    ['section_code' => '17.00', 'section_name' => 'Plumbing'],
                    ['section_code' => '18.00', 'section_name' => 'WCs & Showers'],
                    ['section_code' => '19.00', 'section_name' => 'Builders Works'],
                    ['section_code' => '20.00', 'section_name' => 'Decorations'],
                    ['section_code' => '21.00', 'section_name' => 'Acoustic Treatments'],
                    ['section_code' => '22.00', 'section_name' => 'Floor Finishes'],
                    ['section_code' => '23.00', 'section_name' => 'Joinery'],
                    ['section_code' => '24.00', 'section_name' => 'Tea Point'],
                    ['section_code' => '25.00', 'section_name' => 'Blinds and Manifestations'],
                    ['section_code' => '26.00', 'section_name' => 'Signage'],
                    ['section_code' => '27.00', 'section_name' => 'Staircases'],
                    ['section_code' => '28.00', 'section_name' => 'Miscellaneous'],

            ];

            TemplateSection::insert($data);

    }
}
