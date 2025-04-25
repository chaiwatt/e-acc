<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeEnmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_enms')->insert([
            [
                'activity_th' => "อุตสาหกรรมขนาดเล็กถึงขนาดกลาง",
                'activity_en' => "Industry – Light to medium"
            ],
            [
                'activity_th' => "อุตสาหกรรมขนาดใหญ่",
                'activity_en' => "Industry – Heavy"
            ],
            [
                'activity_th' => "อาคาร",
                'activity_en' => "Building"
            ],
            [
                'activity_th' => "อาคารคอมเพล็กซ์",
                'activity_en' => "Building Complex"
            ],
            [
                'activity_th' => "การขนส่ง",
                'activity_en' => "Transport"
            ],
            [
                'activity_th' => "การทำเหมือง",
                'activity_en' => "Mining"
            ],
            [
                'activity_th' => "การเกษตร",
                'activity_en' => "Agriculture"
            ],
            [
                'activity_th' => "พลังงานภาคอุตสาหกรรม",
                'activity_en' => "Energy supply"
            ]
        ]);

    }
}
