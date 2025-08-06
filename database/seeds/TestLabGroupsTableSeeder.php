<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestLabGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_lab_groups')->insert([
            [
                'name' => 'รป.1',
                'bcertify_test_branche_json_id' => json_encode([1, 2, 9, 25, 24, 30, 10, 7, 27, 28, 29]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'รป.2',
                'bcertify_test_branche_json_id' => json_encode([11, 3, 12, 13, 17, 21, 20, 18, 23, 22, 15]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
