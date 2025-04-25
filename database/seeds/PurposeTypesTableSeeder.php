<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurposeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purpose_types')->insert([
            [
                'name' => 'ยื่นขอครั้งแรก',
            ],
            [
                'name' => 'ต่ออายุใบรับรอง',
            ],
            [
                'name' => 'ขยายขอบข่าย',
            ],
            [
                'name' => 'การเปลี่ยนแปลงมาตรฐาน',
            ],
            [
                'name' => 'ย้ายสถานที่',
            ],
            [
                'name' => 'โอนใบรับรอง',
            ],
        ]);
    }
}
