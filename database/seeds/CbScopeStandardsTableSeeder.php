<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeStandardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_standards')->insert([
            ['standard_th' => 'มอก. 564-2546', 'standard_en' => '(TIS 564-2546 (2003))', 'detail_th' => 'มาตรฐานผลิตภัณฑ์อุตสาหกรรม ภาชนะเซรามิกที่ใช้กับอาหาร: พอร์ชเลน', 'detail_en' => '(Ceramic Ware in Contact with Food : Porcelain)'],
            ['standard_th' => 'ISO 6486-1:1999', 'standard_en' => '(TIS 601-2546 (2003))', 'detail_th' => 'มาตรฐานผลิตภัณฑ์อุตสาหกรรม ภาชนะเซรามิกที่ใช้กับอาหาร: เออร์เทนแวร์', 'detail_en' => '(Ceramic Ware in Contact with Food : Earthenware)'],
            ['standard_th' => 'มอก. 32-2546', 'standard_en' => '(TIS 32-2546 (2003))', 'detail_th' => 'มาตรฐานผลิตภัณฑ์อุตสาหกรรม วิธีทดสอบตะกั่วและแคดเมียมที่ละลายจากภาชนะเซรามิก ภาชนะเซรามิกแก้ว และภาชนะแก้วที่ใช้กับอาหาร', 'detail_en' => '(Test Method for the Release of Lead and Cadmium from Ceramic Ware, Glass-Ceramic Ware and Glassware in Contact with Food)'],
            ['standard_th' => 'มอก. 601-2546', 'standard_en' => '', 'detail_th' => 'Ceramic ware, glass-ceramic ware and glass dinnerware in contact with food - Release of lead and cadmium - Part 1: Test method', 'detail_en' => ''],
        ]);
    }
}
