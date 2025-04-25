<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IbMainCategoryScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ib_main_category_scopes')->insert([
            [
                'name' => 'การตรวจโรงงานเพื่อการรับรองคุณภาพผลิตภัณฑ์',
                'name_en' => 'Factory inspection for product quality certification',
            ],
            [
                'name' => 'เครื่องแต่งกาย: เสื้อผ้าสำเร็จรูป',
                'name_en' => 'Clothing: Ready-to-wear garments'
            ],
            [
                'name' => 'เครื่องแต่งกาย: เสื้อผ้าสำเร็จรูป2',
                'name_en' => 'Clothing: Ready-to-wear garments2'
            ],
            [
                'name' => 'ผลิตภัณฑ์อาหาร: การตรวจผลิตภัณฑ์อาหาร',
                'name_en' => 'Food Products: Food Product Inspection'
            ],
            [
                'name' => 'ยานยนต์: รถยนต์',
                'name_en' => 'Automobile: Car'
            ],
            [
                'name' => 'เครื่องจักรกล: ถังก๊าซปิโตรเลียมเหลว',
                'name_en' => 'Mechanical Engineering: Liquefied Petroleum Gas (LPG) Tank'
            ],
            [
                'name' => 'สินค้าเกษตร',
                'name_en' => 'Agricultural products'
            ],
            [
                'name' => 'สินค้าเกษตร: ผลิตภัณฑ์มันสำปะหลัง',
                'name_en' => 'Agricultural products: Cassava products'
            ]

        ]);
    }
}
