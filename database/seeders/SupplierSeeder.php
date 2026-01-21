<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

    // BUILDERS
    ['business_name'=>'Built FM Projects','business_address'=>'1st Floor, Gallery Court, London, N3 2FG','company_registration_number'=>'08381264','vat_number'=>'158186972','unique_tax_reference'=>'3749623844','supplier_types'=>'3','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-07-31'],
    ['business_name'=>'Acorn Refurbishments','business_address'=>null,'company_registration_number'=>null,'vat_number'=>null,'unique_tax_reference'=>null,'supplier_types'=>'3','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-11-18'],
    ['business_name'=>'OJ Group Ltd','business_address'=>'13 Ripplewaters, St Marys Island, ME4 3BL','company_registration_number'=>'12602712','vat_number'=>'355318105','unique_tax_reference'=>'8843322773','supplier_types'=>'3','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-08-08'],
    ['business_name'=>'Prime Projects','business_address'=>'38 Elton Avenue, Greenford, UB6 0PP','company_registration_number'=>'16018815','vat_number'=>null,'unique_tax_reference'=>'4540527928','supplier_types'=>'3','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-12-01'],

    // CARPENTRY / JOINERY
    ['business_name'=>'T&J Carpentry Ltd','business_address'=>'23 Kenilworth Gardens, Hornchurch, RM12 4SE','company_registration_number'=>'14149211','vat_number'=>'464271489','unique_tax_reference'=>'2287527140','supplier_types'=>'5','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2026-01-15'],
    ['business_name'=>'Martton Ltd','business_address'=>'47 Cherry Tree Lane','company_registration_number'=>'06447899','vat_number'=>'41847485','unique_tax_reference'=>'7429726779','supplier_types'=>'18','pli_cover_value'=>2000000,'insurance_policy_expiry'=>'2026-05-24'],

    // ELECTRICAL
    ['business_name'=>'Hammerhead Electrical Services Ltd','business_address'=>'45 East Dean Road, Eastbourne, BN20 8EJ','company_registration_number'=>'10467162','vat_number'=>'874309701','unique_tax_reference'=>'3727108779','supplier_types'=>'12','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2024-12-06'],
    ['business_name'=>'SSL','business_address'=>'69-70 Long Lane, London, EC1A 9EJ','company_registration_number'=>'11842914','vat_number'=>'320688994','unique_tax_reference'=>'9183011997','supplier_types'=>'12','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-05-20'],

    // MECHANICAL / HVAC
    ['business_name'=>'SES','business_address'=>'4 Claridge Court, Berkhamstead, HP4 2AF','company_registration_number'=>'06726100','vat_number'=>'941390527','unique_tax_reference'=>'2300525192','supplier_types'=>'22','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2026-12-02'],
    ['business_name'=>'Stern Mechanical, Electrical & Building','business_address'=>'406 Roding Lane South, IG8 8EY','company_registration_number'=>'12324380','vat_number'=>'418432112','unique_tax_reference'=>'1647417383','supplier_types'=>'22','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2024-05-16'],
    ['business_name'=>'Stafford Air Conditioning Services','business_address'=>'Unit 2 Marston Rd Trading Estate, Stafford','company_registration_number'=>'04496748','vat_number'=>'715644141','unique_tax_reference'=>'1094907361','supplier_types'=>'22','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-03-26'],
    ['business_name'=>'Arundell HVAC','business_address'=>'Little Canneys Farm, CM3 6RS','company_registration_number'=>'09526030','vat_number'=>null,'unique_tax_reference'=>'2221014368','supplier_types'=>'22','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-06-01'],

    // FIRE
    ['business_name'=>'Keystone Fire Safety','business_address'=>'6 Triumph Way, Kempston, MK42 7QB','company_registration_number'=>'08389055','vat_number'=>'163924202','unique_tax_reference'=>'2196911560','supplier_types'=>'13','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2024-11-17'],
    ['business_name'=>'Sensetech Systems Ltd','business_address'=>'93 Great Suffolk St, London SE1','company_registration_number'=>'07375035','vat_number'=>'997441173','unique_tax_reference'=>'1118414019','supplier_types'=>'13','pli_cover_value'=>10000000,'insurance_policy_expiry'=>'2025-10-14'],

    // FLOORING
    ['business_name'=>'CVT Flooring','business_address'=>'Foremost House, Billericay','company_registration_number'=>'11140686','vat_number'=>'287052880','unique_tax_reference'=>'9797822492','supplier_types'=>'14','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2026-02-06'],
    ['business_name'=>'Oracle Flooring','business_address'=>'66 College Road, HA1 1BE','company_registration_number'=>'14083644','vat_number'=>'428641681','unique_tax_reference'=>'3335497795','supplier_types'=>'14','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2026-05-03'],
    ['business_name'=>'Selby Contract Flooring','business_address'=>'24 Crimscott Street, London','company_registration_number'=>'OC430736','vat_number'=>'355028508','unique_tax_reference'=>'2755053900','supplier_types'=>'14','pli_cover_value'=>10000000,'insurance_policy_expiry'=>'2025-01-05'],

    // GLAZING / PARTITIONS
    ['business_name'=>'Evolution Glass','business_address'=>'Unit 7 Copthorne Business Park','company_registration_number'=>'06596637','vat_number'=>'934159025','unique_tax_reference'=>'584192722','supplier_types'=>'16','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2025-06-30'],
    ['business_name'=>'Forme Partitions','business_address'=>'Pennygillam Industrial Estate','company_registration_number'=>'06947597','vat_number'=>'933353878','unique_tax_reference'=>'1655012516','supplier_types'=>'16','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2026-02-21'],

    // SIGNAGE
    ['business_name'=>'Team Graphics','business_address'=>'Poyle Road, Colnbrook','company_registration_number'=>'06727375','vat_number'=>'940959393','unique_tax_reference'=>'2816403062','supplier_types'=>'25','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2024-11-27'],
    ['business_name'=>'Signbox','business_address'=>null,'company_registration_number'=>null,'vat_number'=>null,'unique_tax_reference'=>null,'supplier_types'=>'25','pli_cover_value'=>null,'insurance_policy_expiry'=>null],

    // CLEANING
    ['business_name'=>'Merit Cleaning Services Ltd','business_address'=>'5 Heron Close, Uxbridge','company_registration_number'=>'04169200','vat_number'=>'769996236','unique_tax_reference'=>'3876402999','supplier_types'=>'6','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2024-09-04'],

    // ASBESTOS
    ['business_name'=>'Kent Asbestos Services','business_address'=>'Higham, Rochester, Kent','company_registration_number'=>'13032417','vat_number'=>'443413028','unique_tax_reference'=>'8580924560','supplier_types'=>'1','pli_cover_value'=>5000000,'insurance_policy_expiry'=>'2024-09-29'],

    // MASTIC
    ['business_name'=>'Miles of Mastic','business_address'=>'6 Meadowlands, Hornchurch','company_registration_number'=>'05311808','vat_number'=>'765916292','unique_tax_reference'=>'1352422429','supplier_types'=>'21','pli_cover_value'=>10000000,'insurance_policy_expiry'=>'2024-09-21'],

    // BUILDING CONTROL
    ['business_name'=>'London Building Control','business_address'=>null,'company_registration_number'=>null,'vat_number'=>null,'unique_tax_reference'=>null,'supplier_types'=>'29','pli_cover_value'=>null,'insurance_policy_expiry'=>null],
];


        foreach ($data as $item) {
            Supplier::updateOrCreate(
                ['business_name' => $item['business_name']],
                [
                    'business_address' => $item['business_address'],
                    'unique_tax_reference' => $item['unique_tax_reference'],
                    'company_registration_number' => $item['company_registration_number'],
                    'vat_number' => $item['vat_number'],
                    'supplier_types' => $item['supplier_types'],
                    'pli_cover_value' => $item['pli_cover_value'],
                    'insurance_policy_expiry' => $item['insurance_policy_expiry'],
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}
