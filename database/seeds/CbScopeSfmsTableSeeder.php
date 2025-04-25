<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeSfmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_sfms')->insert([
            ['scope_th' => 'สวนป่าไม้เศรษฐกิจทุกประเภท','scope_en' => 'Forst Plantation', 'activity_th' => 'มอก. 14061 เล่ม 1', 'activity_en' => 'TIS 14061-1'],
        ]);
    }
}
