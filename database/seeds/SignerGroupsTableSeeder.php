<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SignerGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // ข้อมูล signer_ids ที่เป็น JSON
        $signerIds = json_encode([174, 175, 167]);

        // ข้อมูลกลุ่มนักร้องที่จะเพิ่ม
        $groups = [
            [
                'name' => 'lab',
                'signer_ids' => $signerIds,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ib',
                'signer_ids' => $signerIds,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'cb',
                'signer_ids' => $signerIds,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // เพิ่มข้อมูลลงในตาราง
        DB::table('signer_groups')->insert($groups);
    }
}
