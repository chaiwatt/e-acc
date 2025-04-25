<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalibrationBranchParam2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('calibration_branch_param2s')->insert([
            [
                'calibration_branch_instrument_group_id' => 11,
                'name' => 'Applied DC signal'
            ],
            [
                'calibration_branch_instrument_group_id' => 11,
                'name' => 'Applied square wave'
            ],
            [
                'calibration_branch_instrument_group_id' => 11,
                'name' => 'Time maker'
            ],
            [
                'calibration_branch_instrument_group_id' => 11,
                'name' => 'Digital bandwidth'
            ],
            [
                'calibration_branch_instrument_group_id' => 12,
                'name' => 'Time maker'
            ],
            [
                'calibration_branch_instrument_group_id' => 12,
                'name' => 'Analog bandwidth'
            ],
            [
                'calibration_branch_instrument_group_id' => 12,
                'name' => 'Applied square wave'
            ],
            [
                'calibration_branch_instrument_group_id' => 38,
                'name' => 'Quasi-peak (QP) detector'
            ],
            [
                'calibration_branch_instrument_group_id' => 38,
                'name' => 'Average (AV) detector'
            ],
            [
                'calibration_branch_instrument_group_id' => 38,
                'name' => 'RMS detector'
            ],
            [
                'calibration_branch_instrument_group_id' => 220,
                'name' => 'Increasing only'
            ],
            [
                'calibration_branch_instrument_group_id' => 220,
                'name' => 'Decreasing only'
            ],
            [
                'calibration_branch_instrument_group_id' => 220,
                'name' => 'Increasing and decreasing'
            ],
            [
                'calibration_branch_instrument_group_id' => 238,
                'name' => 'Volume of liquid (water)'
            ],
            [
                'calibration_branch_instrument_group_id' => 238,
                'name' => 'Mass of liquid (water)'
            ],
            [
                'calibration_branch_instrument_group_id' => 238,
                'name' => 'Standard mode'
            ],
            [
                'calibration_branch_instrument_group_id' => 238,
                'name' => 'Actual mode'
            ],
            [
                'calibration_branch_instrument_group_id' => 239,
                'name' => 'Dry air'
            ],
            [
                'calibration_branch_instrument_group_id' => 239,
                'name' => 'Nitrogen'
            ],
            [
                'calibration_branch_instrument_group_id' => 240,
                'name' => 'Dry air'
            ],
            [
                'calibration_branch_instrument_group_id' => 240,
                'name' => 'Nitrogen'
            ],
            [
                'calibration_branch_instrument_group_id' => 241,
                'name' => 'Dry air'
            ],
            [
                'calibration_branch_instrument_group_id' => 241,
                'name' => 'Nitrogen'
            ],
            [
                'calibration_branch_instrument_group_id' => 284,
                'name' => 'H*(10) Rate'
            ],
            [
                'calibration_branch_instrument_group_id' => 284,
                'name' => 'Hp(10)'
            ],
            [
                'calibration_branch_instrument_group_id' => 284,
                'name' => 'superficial Hp(0.07)'
            ],
            [
                'calibration_branch_instrument_group_id' => 285,
                'name' => 'H*(10) Rate'
            ],
            [
                'calibration_branch_instrument_group_id' => 285,
                'name' => 'Hp(10)'
            ],
            [
                'calibration_branch_instrument_group_id' => 298,
                'name' => 'Gauge pressure (Pe)'
            ], 
        ]);
    }
}
