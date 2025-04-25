<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeGhgSectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_ghg_sectors')->insert([
            [
                'sector_th' => 'การผลิตพลังงาน และการจัดการพลังงานไฟฟ้า', 
                'sector_en' => '(Power Generation and Electric Power Transactions)'
            ],
            [
                'sector_th' => 'อุตสาหกรรมการผลิตทั่วไป', 
                'sector_en' => '(General Manufacturing Industries)'
            ],
            [
                'sector_th' => 'การสำรวจ การผลิต การกลั่นน้ำมันปิโตรเลียมและก๊าซ และการจัดส่งทางท่อ รวมถึงอุตสาหกรรมปิโตรเคมี', 
                'sector_en' => '(Oil and Gas Exploration, Extraction, Production and Refining, and pipeline distribution, including Petrochemicals)'
            ],
            [
                'sector_th' => 'อุตสาหกรรมการผลิตโลหะ', 
                'sector_en' => '(Metals Production)'
            ],
            [
                'sector_th' => 'อุตสาหกรรมการผลิตอะลูมิเนียม', 
                'sector_en' => '(Aluminum Production)'
            ],
            [
                'sector_th' => 'การทำเหมืองและการผลิตแร่', 
                'sector_en' => '(Mining and Mineral Production)'
            ],
            [
                'sector_th' => 'อุตสาหกรรมด้านพลังงาน', 
                'sector_en' => '(Energy demand)'
            ],
            [
                'sector_th' => 'อุตสาหกรรมการผลิต', 
                'sector_en' => '(Manufacturing industries)'
            ],
            [
                'sector_th' => 'อุตสาหกรรมเคมี', 
                'sector_en' => '(Chemical industry)'
            ],
            [
                'sector_th' => 'การขนส่ง', 
                'sector_en' => '(Transport)'
            ],
            [
                'sector_th' => 'การจัดการและกำจัดของเสีย', 
                'sector_en' => '(Waste handling and disposal)'
            ],
        ]);
    }
}
