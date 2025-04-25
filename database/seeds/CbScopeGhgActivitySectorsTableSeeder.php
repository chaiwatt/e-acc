<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeGhgActivitySectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_ghg_activity_sectors')->insert([
            [
                'cb_scope_ghg_activity_id' => 1,
                'cb_scope_ghg_sector_id' => 1
            ],
            [
                'cb_scope_ghg_activity_id' => 1,
                'cb_scope_ghg_sector_id' => 2
            ],
            [
                'cb_scope_ghg_activity_id' => 1,
                'cb_scope_ghg_sector_id' => 3
            ],
            [
                'cb_scope_ghg_activity_id' => 1,
                'cb_scope_ghg_sector_id' => 4
            ],
            [
                'cb_scope_ghg_activity_id' => 1,
                'cb_scope_ghg_sector_id' => 5
            ],
            [
                'cb_scope_ghg_activity_id' => 2,
                'cb_scope_ghg_sector_id' => 6
            ],
            [
                'cb_scope_ghg_activity_id' => 2,
                'cb_scope_ghg_sector_id' => 7
            ],
            [
                'cb_scope_ghg_activity_id' => 2,
                'cb_scope_ghg_sector_id' => 8
            ],
            [
                'cb_scope_ghg_activity_id' => 2,
                'cb_scope_ghg_sector_id' => 9
            ],
            [
                'cb_scope_ghg_activity_id' => 2,
                'cb_scope_ghg_sector_id' => 10
            ],
        ]);
    }
}
