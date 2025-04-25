<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeGhgActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_ghg_activities')->insert([
            [
                'activity_th' => 'การตรวจสอบความใช้ได้และทวนสอบก๊าซเรือนกระจกระดับโครงการลดก๊าซเรือนกระจกภาคสมัครใจตามมาตรฐานของประเทศไทย (ISO 14064-2:2019) ตามแนวทางการตรวจสอบ และทวนสอบโครงการลดก๊าซเรือนกระจกภาคสมัครใจตามมาตรฐานประเทศไทยของ องค์การบริหารจัดการก๊าซเรือนกระจก (องคPการมหาชน)', 
                'activity_en' => '(Validation and verification of Thailand Voluntary Emission Reduction Program: (ISO 14064-2:2019) according to the guidance of validation and verification of Thailand Voluntary Emission Reduction program of Thailand Greenhouse Gas Management Organization (Public Organization))'
            ],
            [
                'activity_th' => 'การทวนสอบรายงานผลการปลดปล่อยและลดปริมาณก>าซเรือนกระจกระดับองค์กรตามมาตรฐาน ISO 14064-1:2018 โดยโปรแกรมการทวนสอบที่ตกลงกัน', 
                'activity_en' => '(Verification of greenhouse gas emissions and removals report at the organization level according to ISO 14064-1:2018 based verification engagement programme)'
            ],
        ]);
    }
}
