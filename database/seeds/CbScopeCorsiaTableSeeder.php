<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeCorsiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_corsias')->insert([
            ['sector' => "การขนส่งทางอากาศ", 'sector_en' => 'Aviation', 'criteria' => '- ICAO International Standard and Recommended Practice, Annex 16, Volume IV<br> – Carbon Offsetting and Reduction Scheme for International Aviation – Standard and Recommended Practices (SARPs)'],

        ]);
    }
}

