<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopePersonalScopeListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_personal_scope_lists')->insert([
            ['txt_th' => 'อาชีพสรรหาและคัดเลือกบุคลากร ระดับ 3', 'txt_en' => '(Occupation : Attraction & Selection Level 3)'],
            ['txt_th' => 'อาชีพบริหารค่าตอบแทน ระดับ 3', 'txt_en' => '(Occupation : Remuneration Management Level 3)'],
            ['txt_th' => 'อาชีพบริหารค่าตอบแทน ระดับ 3', 'txt_en' => '(Occupation : Remuneration Management Level 3)'],
            ['txt_th' => 'อาชีพพนักงานสัมพันธ์ ระดับ 3', 'txt_en' => '(Occupation : Employee Relations Level 3)'],
            ['txt_th' => 'อาชีพเรียนรู้และพัฒนาทรัพยากรบุคคล ระดับ 3', 'txt_en' => '(Occupation: Learning and Development Level 3)'],
        ]);
    }
}
