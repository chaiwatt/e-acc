<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopePersonalScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_personal_scopes')->insert([
            ['txt_th' => 'สาขาวิชาชีพบริหารงานบุคคล สาขาอาชีพบริหารทรัพยากรบุคคล', 'txt_en' => '(Sector : Personnel Management, Sub-Sector : Human Resource Management)'],
            ['txt_th' => 'สาขาวิชาชีพบริหารงานบุคคล สาขาอาชีพพัฒนาทรัพยากรบุคคล', 'txt_en' => '(Sector : Personnel Management, Sub-Sector : Human Resources Development)'],
        ]);
    }
}
