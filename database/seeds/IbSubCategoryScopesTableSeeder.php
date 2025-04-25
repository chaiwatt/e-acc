<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IbSubCategoryScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ib_sub_category_scopes')->insert([
            [
                'ib_main_category_scope_id' => 1,
                'name' => 'การตรวจโรงงานเพื่อการรับรองคุณภาพผลิตภัณฑ์',
                'name_en' => 'Factory inspection for product quality certification'
            ],
            [
                'ib_main_category_scope_id' => 2,
                'name' => 'เครื่องแต่งกาย: เสื้อผ้าสำเร็จรูป',
                'name_en' => 'Apparel: Ready-made clothing'  
            ],
            [
                'ib_main_category_scope_id' => 3,
                'name' => 'เครื่องแต่งกาย : เสื้อผ้าสําเร็จรูป2',
                'name_en' => 'Apparel: Ready-made clothing2'  
            ],
            [
                'ib_main_category_scope_id' => 4,
                'name' => 'ผลิตภัณฑ์อาหาร: การตรวจผลิตภัณฑ์อาหาร',
                'name_en' => 'Food products: Food product inspection'  
            ],
            [
                'ib_main_category_scope_id' => 5,
                'name' => 'ยานยนต์: รถยนต์',
                'name_en' => 'Automobiles: Car'  
            ],
            [
                'ib_main_category_scope_id' => 6,
                'name' => 'เครื่องจักรกล: ถังก๊าซปิโตรเลียมเหลว',
                'name_en' => 'Mechanical Engineering: Liquefied Petroleum Gas (LPG) Tank'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าวหอมมะลิไทย',
                'name_en' => 'Thai Jasmine Rice'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าวหอมไทย',
                'name_en' => 'Thai Fragrant Rice'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าวขาว,ข้าวกล้อง,ข้าวเหนียวขาว,ข้าวนึ่ง',
                'name_en' => 'White rice,Brown rice,White sticky rice,Steamed rice'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'น้ำตาลทรายขาว,น้ำตาลทรายดิบ',
                'name_en' => 'White sugar,Raw sugar'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าวสาลี,กากถั่วเหลือง',
                'name_en' => 'Wheat,Soybean meal'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'เมล็ดธัญพืช',
                'name_en' => 'Grain seeds'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าว',
                'name_en' => 'Rice'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'น้ำตาลทรายขาวบริสุทธิ์,น้ำตาลทรายดิบ',
                'name_en' => 'Refined white sugar,Raw sugar'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าว,ผลิตภัณฑ์อาหารสัตว์,ผลิตภัณฑ์เชื้อเพลิงชีวมวล',
                'name_en' => 'Rice,Animal feed products,Biomass fuel products'
                  
            ],
            [
                'ib_main_category_scope_id' => 8,
                'name' => 'สินค้าเกษตร : ผลิตภัณฑ์มันสําปะหลัง',
                'name_en' => 'Agricultural products:Cassava products'  
            ]
          

        ]);
    }
}
