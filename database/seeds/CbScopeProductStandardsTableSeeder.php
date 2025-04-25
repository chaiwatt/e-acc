<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeProductStandardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_product_standards')->insert([
            ['cb_scope_product_id' => 1, 'cb_scope_standard_id' => 1],
            ['cb_scope_product_id' => 1, 'cb_scope_standard_id' => 3],
            ['cb_scope_product_id' => 1, 'cb_scope_standard_id' => 4],
            ['cb_scope_product_id' => 2, 'cb_scope_standard_id' => 2],
            ['cb_scope_product_id' => 2, 'cb_scope_standard_id' => 3],
            ['cb_scope_product_id' => 2, 'cb_scope_standard_id' => 4],
        ]);
    }
}


