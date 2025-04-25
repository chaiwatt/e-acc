<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeOhsmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_ohsms')->insert([
            ['iaf' => 1, 'activity_th' => 'เกษตรกรรม การป่าไม้ และการประมง', 'activity_en' => 'Agriculture, forestry and fishing'],
            ['iaf' => 2, 'activity_th' => 'การทำเหมืองแร่และเหมืองหิน', 'activity_en' => 'Mining and quarrying'],
            ['iaf' => 3, 'activity_th' => 'การผลิตอาหารและเครื่องดื่ม', 'activity_en' => 'Food products, beverages and tobacco'],
            ['iaf' => 4, 'activity_th' => 'การผลิตสิ่งทอ และการผลิตภัณฑ์สิ่งทอ', 'activity_en' => 'Textiles and textile products'],
            ['iaf' => 5, 'activity_th' => 'การผลิตหนังและผลิตภัณฑ์หนัง', 'activity_en' => 'Leather and leather products'],
            ['iaf' => 6, 'activity_th' => 'การผลิตไม้และผลิตภัณฑ์ไม้', 'activity_en' => 'Wood and wood products'],
            ['iaf' => 7, 'activity_th' => 'การผลิตเยื่อกระดาษ และผลิตภัณฑ์กระดาษ', 'activity_en' => 'Pulp and paper products'],
            ['iaf' => 8, 'activity_th' => 'การทำสิ่งพิมพ์', 'activity_en' => 'Publishing companies'],
            ['iaf' => 9, 'activity_th' => 'การพิมพ์', 'activity_en' => 'Printing companies'],
            ['iaf' => 10, 'activity_th' => 'การผลิตถ่านหินและผลิตภัณฑ์ปิโตรเลียมที่ผ่านการกลั่น', 'activity_en' => 'Manufacture of coke and refined petroleum products'],
            ['iaf' => 11, 'activity_th' => 'การผลิตเชื้อเพลิงนิวเคลียร์', 'activity_en' => 'Nuclear fuel'],
            ['iaf' => 12, 'activity_th' => 'การผลิตสารเคมี ผลิตภัณฑ์เคมี', 'activity_en' => 'Chemicals, chemical products and fibres'],
            ['iaf' => 13, 'activity_th' => 'การผลิตยา', 'activity_en' => 'Pharmaceuticals'],
            ['iaf' => 14, 'activity_th' => 'การผลิตยางและผลิตภัณฑ์พลาสติก', 'activity_en' => 'Rubber and plastic products'],
            ['iaf' => 15, 'activity_th' => 'การผลิตผลิตภัณฑ์จากแร่อโลหะ', 'activity_en' => 'Non-metallic mineral products'],
            ['iaf' => 16, 'activity_th' => 'การผลิตผลิตภัณฑ์คอนกรีต ปูนซีเมนต์ ปูนไลม์ ปูนปลาสเตอร์ และอื่นๆ', 'activity_en' => 'Concrete, cement, lime, plaster, etc'],
            ['iaf' => 17, 'activity_th' => 'การผลิตโลหะขั้นมูลฐานและผลิตภัณฑ์ที่ทำจากโลหะประดิษฐ์', 'activity_en' => 'Base metals production and fabricated metal products'],
            ['iaf' => 18, 'activity_th' => 'การผลิตเครื่องจักรกลและอุปกรณ์', 'activity_en' => 'Machinery and equipment'],
            ['iaf' => 19, 'activity_th' => 'การผลิตเครื่องจักรกลไฟฟ้าและอุปกรณ์เกี่ยวกับสายตา', 'activity_en' => 'Electrical and optical equipment'],
            ['iaf' => 20, 'activity_th' => 'การต่อเรือ', 'activity_en' => 'Shipbuilding'],
            ['iaf' => 21, 'activity_th' => 'การผลิตอากาศยาน', 'activity_en' => 'Aerospace'],
            ['iaf' => 22, 'activity_th' => 'การผลิตอุปกรณ์ขนส่งอื่นๆ', 'activity_en' => 'Other transport equipment'],
            ['iaf' => 23, 'activity_th' => 'การผลิตที่มิได้ระบุไว้ที่อื่น', 'activity_en' => 'Manufacturing not elsewhere classified'],
            ['iaf' => 24, 'activity_th' => 'การนำกลับมาใช้ใหม่', 'activity_en' => 'Recycling'],
            ['iaf' => 25, 'activity_th' => 'การผลิตและจ่ายไฟฟ้า', 'activity_en' => 'Electricity supply'],
            ['iaf' => 26, 'activity_th' => 'การผลิตและจ่ายก๊าซ', 'activity_en' => 'Gas supply'],
            ['iaf' => 27, 'activity_th' => 'การผลิตและจ่ายน้ำ และไอน้ำ', 'activity_en' => 'Water supply'],
            ['iaf' => 28, 'activity_th' => 'การก่อสร้าง', 'activity_en' => 'Construction'],
            ['iaf' => 29, 'activity_th' => 'การขายส่ง การขายปลีก การซ่อมแซมยานยนต์ รถจักรยานยนต์ ของใช้ส่วนบุคคล และของใช้ภายในบ้าน', 'activity_en' => 'Wholesale and retail trade; Repair of motor vehicles, motorcycles and personal and household goods'],
            ['iaf' => 30, 'activity_th' => 'โรงแรม และภัตตาคาร', 'activity_en' => 'Hotels and restaurants'],
            ['iaf' => 31, 'activity_th' => 'การขนส่ง การเก็บรักษา และการคมนาคม', 'activity_en' => 'Transport, storage and communication'],
            ['iaf' => 32, 'activity_th' => 'การเป็นตัวกลางทางการเงิน การค้าอสังหาริมทรัพย์ การให้เช่า', 'activity_en' => 'Financial intermediation; real estate renting'],
            ['iaf' => 33, 'activity_th' => 'เทคโนโลยีสารสนเทศ', 'activity_en' => 'Information technology'],
            ['iaf' => 34, 'activity_th' => 'การบริการทางวิศวกรรม', 'activity_en' => 'Engineering services'],
            ['iaf' => 35, 'activity_th' => 'การบริการอื่น ๆ', 'activity_en' => 'Other services'],
            ['iaf' => 36, 'activity_th' => 'การบริหารราชการ', 'activity_en' => 'Public administrations'],
            ['iaf' => 37, 'activity_th' => 'การศึกษา', 'activity_en' => 'Education'],
            ['iaf' => 38, 'activity_th' => 'การบริการเกี่ยวกับสุขภาพและสังคมสงเคราะห์', 'activity_en' => 'Health and social work'],
            ['iaf' => 39, 'activity_th' => 'การบริการทางสังคมอื่นๆ', 'activity_en' => 'Other social services'],
        ]);
    }
}
