<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopePersonalSchemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_personal_schemes')->insert([
            ['txt_th' => 'หลักเกณฑ์และเงื่อนไขในการรับรอง (RE-THRCI-EXM-01) แก้ไขครั้งที่ 02 วันที่บังคับใช้ 27 กรกฎาคม 2566', 'txt_en' => '(Regulation for Certification (RE-THRCI-EXM-01), Revision 02, Effective date 27 July 2023)'],
            ['txt_th' => 'มาตรฐานอาชีพและคุณวุฒิวิชาชีพ สาขาวิชาชีพบริหารงานบุคคล พ.ศ. 2564', 'txt_en' => '(Professional Qualifications and Occupational Standards in Personnel Management Sector 2021)'],
        ]);
    }
}
