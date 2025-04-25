<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_products')->insert([
            ['product_th' => 'พอร์ซเลน', 'product_en' => '(Porcelain)'],
            ['product_th' => 'เออร์เทนแวร์', 'product_en' => '(Earthenware)'],
        ]);
    }
}
