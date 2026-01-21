<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SupplierContact;
use App\Models\Supplier;

class SupplierContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $contacts = [
            ['Built FM Projects','Seth Moloney','seth@builtgroup.co.uk','07972 588 118'],
            ['Acorn Refurbishments','Simon Wilkinson','simon@acornr.co.uk','07768 621996'],
            ['OJ Group Ltd','Oliver J Potter','oliver@ojg.limited','07805 429993'],
            ['T&J Carpentry Ltd','Joshua Evans','tjcarpentryltd@hotmail.com','07957 111737'],
            ['SES','Lee Stewart','lee@sesukltd.com','07713 151563'],
            ['Hammerhead Electrical Services Ltd','Ivan Hunt','ivan@hammer-head.co.uk','07795 184944'],
            ['Evolution Glass','Phil Wilsher','phil@evolutionglass.co.uk','07971 830030'],
            ['Team Graphics','Paul Crooks','paul@teamgraphics.co.uk','07940 117555'],
            ['Kent Asbestos Services','Jake Parsons','jake.parsons@kentasbestossolutions.co.uk','07807 737174'],
            ['Merit Cleaning Services Ltd','Daniel Knight','meritcleaning@hotmail.com','07834 267109'],
        ];

        foreach ($contacts as [$supplierName,$name,$email,$phone]) {
            if ($supplier = Supplier::where('business_name',$supplierName)->first()) {
                SupplierContact::updateOrCreate(
                    ['supplier_id'=>$supplier->id,'email'=>$email],
                    ['contact_name'=>$name,'phone'=>$phone]
                );
            }
        }
    }
}
