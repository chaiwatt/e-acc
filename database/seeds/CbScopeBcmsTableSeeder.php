<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeBcmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_bcms')->insert([
            ['category' => 'A', 'activity_th' => 'เกษตรกรรม การล่าสัตว์ และการป่าไม้', 'activity_en' => 'Agriculture, Hunting and Forestry'],
            ['category' => 'B', 'activity_th' => 'การประมง', 'activity_en' => 'Fishing'],
            ['category' => 'C', 'activity_th' => 'การทำเหมืองแร่และเหมืองหิน', 'activity_en' => 'Mining and Quarrying'],
            ['category' => 'D', 'activity_th' => 'การผลิต', 'activity_en' => 'Manufacturing'],
            ['category' => 'E', 'activity_th' => 'การจ่ายไฟฟ้า ก๊าซ และน้ำ', 'activity_en' => 'Electricity, Gas and Water Supply'],
            ['category' => 'F', 'activity_th' => 'การก่อสร้าง', 'activity_en' => 'Construction'],
            ['category' => 'G', 'activity_th' => 'การขายส่ง การขายปลีก การซ่อมแซมยานยนต์ รถจักรยายนต์ ของใช้ส่วนบุคคล และของใช้ภายในบ้าน', 'activity_en' => 'Wholesale and Retail Trade; Repair of Motor Vehicles, Motorcycles and Personal and Household goods'],
            ['category' => 'H', 'activity_th' => 'โรงแรมและภัตตาคาร', 'activity_en' => 'Hotels and Restaurants'],
            ['category' => 'I', 'activity_th' => 'การขนส่ง การเก็บรักษา และการคมนาคม', 'activity_en' => 'Transport, Storage and Communications'],
            ['category' => 'J', 'activity_th' => 'การเป็นตัวกลางทางการเงิน', 'activity_en' => 'Financial Intermediation'],
            ['category' => 'K', 'activity_th' => 'การค้าอสังหาริมทรัพย์ การให้เช่า และกิจกรรมทางธุรกิจ', 'activity_en' => 'Real Estate, Renting and Business Activities'],
            ['category' => 'L', 'activity_th' => 'การบริหารราชการและการป้องกันประเทศ การประกันสังคมแบบบังคับ', 'activity_en' => 'Public Administration and Defense; Compulsory Social Security'],
            ['category' => 'M', 'activity_th' => 'การศึกษา', 'activity_en' => 'Education'],
            ['category' => 'N', 'activity_th' => 'การบริการเกี่ยวกับสุขภาพ และงานสังคมสงเคราะห์', 'activity_en' => 'Health and Social Work'],
            ['category' => 'O', 'activity_th' => 'การบริการชุมชน สังคม และการบริการส่วนบุคคลอื่น ๆ', 'activity_en' => 'Other Community, Society and Personal Service Activities'],
            ['category' => 'P', 'activity_th' => 'บ้านส่วนบุคคลพร้อมลูกจ้าง', 'activity_en' => 'Private Households with Employed Persons'],
        ]);
    }
}
