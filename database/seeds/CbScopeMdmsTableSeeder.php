<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeMdmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_mdms')->insert([
            ['code_sector' => 1, 'activity_th' => 'เครื่องมือแพทย์ที่ไม่มีกําลัง (ไม่ฝังในร่างกายและฝังในร่างกาย)', 'activity_en' => 'Non-Active Medical Devices'],
            ['code_sector' => 2, 'activity_th' => 'เครื่องมือแพทย์ที่มีกําลังและไม่ฝังในร่างกาย', 'activity_en' => 'Active Medical Devices (Non-Implantable)'],
            ['code_sector' => 3, 'activity_th' => 'เครื่องมือแพทย์ที่มีกําลังและฝังในร่างกาย', 'activity_en' => 'Active Implantable Medical Devices'],
            ['code_sector' => 4, 'activity_th' => 'เครื่องมือแพทย์สําหรับการวินิจฉัยภายนอกร่างกาย', 'activity_en' => 'In Vitro Diagnostic Medical Devices (IVD)'],
            ['code_sector' => 5, 'activity_th' => 'วิธีการทําให้ปราศจากเชื้อสําหรับเครื่องมือแพทย์', 'activity_en' => 'Sterilization Method for Medical Devices'],
            ['code_sector' => 6, 'activity_th' => 'การรวมอุปกรณ์/การใช้สารเฉพาะ/เทคโนโลยี', 'activity_en' => 'Devices Incorporating / Utilizing Specific Substances / Technologies'],
            ['code_sector' => 7, 'activity_th' => 'ส่วนประกอบ หรือ การบริการ', 'activity_en' => 'Parts or Services'],
        ]);
    }
}


 