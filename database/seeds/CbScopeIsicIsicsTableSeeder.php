<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeIsicIsicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_isic_isics')->insert([
            [
                'isic_code' => '1',
                'description_th' => 'เกษตรกรรม ล่าสัตว์ และการป่าไม้',
                'description_en' => 'Agriculture, Hunting and Related Service Activities'
              ],
              [
                'isic_code' => '2',
                'description_th' => 'การทำป่าไม้ การตัดไม้ และกิจกรรมบริการที่เกี่ยวข้อง',
                'description_en' => 'Forestry, Logging and Related Service Activities'
              ],
              [
                'isic_code' => '5',
                'description_th' => 'การประมง การเพาะพันธุ์ปลาและการทำฟาร์มเลี้ยงปลา กิจกรรมบริการทางการประมง',
                'description_en' => 'Fishing, Operation of Fish Hatcheries and Fish Farms; Service Activities Incidental to Fishing'
              ],
              [
                'isic_code' => '10',
                'description_th' => 'การทำเหมืองถ่านหินและลิกไนต์ การสกัดถ่านหินชนิดร่วน',
                'description_en' => 'Mining of Coal and Lignite; Extraction of Peat'
              ],
              [
                'isic_code' => '11',
                'description_th' => 'การขุดเจาะน้ำมันปิโตรเลียมและก๊าซธรรมชาติ กิจกรรมบริการที่เกี่ยวข้องกับการขุดเจาะน้ำมันและก๊าซ ยกเว้นการสำรวจ',
                'description_en' => 'Extraction of Crude Petroleum and Natural Gas; Service Activities Incidental to Oil and Gas Extraction Excluding Surveying'
              ],
              [
                'isic_code' => '12',
                'description_th' => 'การทำเหมืองแร่ยูเรเนียมและแร่ทอเรียม',
                'description_en' => 'Mining of Uranium and Thorium Ores'
              ],
              [
                'isic_code' => '13',
                'description_th' => 'การทำเหมืองแร่โลหะ',
                'description_en' => 'Mining of Metal Ores'
              ],
              [
                'isic_code' => '14',
                'description_th' => 'การทำเหมืองแร่อื่น ๆ และเหมืองหิน',
                'description_en' => 'Other Mining and Quarrying'
              ],
              [
                'isic_code' => '15',
                'description_th' => 'การผลิตผลิตภัณฑ์อาหารและเครื่องดื่ม',
                'description_en' => 'Manufacture of Food Products and Beverages'
              ],
              [
                'isic_code' => '16',
                'description_th' => 'การผลิตผลิตภัณฑ์ยาสูบ',
                'description_en' => 'Manufacture of Tobacco Products'
              ],
              [
                'isic_code' => '17',
                'description_th' => 'การผลิตสิ่งทอ',
                'description_en' => 'Manufacture of Textiles'
              ],
              [
                'isic_code' => '18',
                'description_th' => 'การผลิตเครื่องแต่งกาย การตกแต่ง และการย้อมสีขนสัตว์',
                'description_en' => 'manufacture of wearing apparel; drssing and dyeing of fur'
              ],
              [
                'isic_code' => '19',
                'description_th' => 'การฟอกหนังและการตกแต่งหนัง การผลิตกระเป๋าเดินทาง กระเป๋าถือ อานม้า บังเหียน และรองเท้า',
                'description_en' => 'Tanning and Dressing of Leather; Manufacture of Luggage, Handbags, Saddlery, Harness and Footwear'
              ],
              [
                'isic_code' => '20',
                'description_th' => 'การผลิตไม้และผลิตภัณฑ์ไม้และไม้ก๊อก ยกเว้นเครื่องเรือน การผลิตสินค้าที่ฟางและวัสดุถัก',
                'description_en' => 'Manufacture of Wood and of Products of Wood and Cork, Except Furniture; Manufacture of Articles of Straw and Plaiting Materials'
              ],
              [
                'isic_code' => '21',
                'description_th' => 'การผลิตกระดาษและผลิตภัณฑ์กระดาษ',
                'description_en' => 'Manufacture of Paper and Paper Products'
              ],
              [
                'isic_code' => '22',
                'description_th' => 'การทำสิ่งพิมพ์ การพิมพ์ และการทำสำเนาสื่อบันทึก',
                'description_en' => 'Publishing, Printing and Reproduction of Recorded Media'
              ],
              [
                'isic_code' => '23',
                'description_th' => 'การผลิตถ่านหิน ผลิตภัณฑ์ปิโตรเลียมที่ผ่านการกลั่น และเชื้อเพลิงนิวเคลียร์',
                'description_en' => 'Manufacture of Coke, Refined Petroleum Products and Nuclear Fuel'
              ],
              [
                'isic_code' => '24',
                'description_th' => 'การผลิตสารเคมี และผลิตภัณฑ์เคมี',
                'description_en' => 'Manufacture of Chemicals and Chemical Products'
              ],
              [
                'isic_code' => '25',
                'description_th' => 'การผลิตยาง และผลิตภัณฑ์พลาสติก',
                'description_en' => 'Manufacture of Rubber and Plastics Products'
              ],
              [
                'isic_code' => '26',
                'description_th' => 'กรผลิตผลิตภัณฑ์อื่น ๆ จากแร่อโลหะ',
                'description_en' => 'Manufacture of Other Non-Metallic Mineral Products'
              ],
              [
                'isic_code' => '27',
                'description_th' => 'การผลิตโลหะขั้นมูลฐาน',
                'description_en' => 'Manufacture of Basic Metals'
              ],
              [
                'isic_code' => '28',
                'description_th' => 'การผลิตผลิตภัณฑ์ที่ทำจากโลหะประดิษฐ์ ยกเว้นเครื่องจักรและอุปกรณ์',
                'description_en' => 'Manufacture of Fabricated Metal Products, Except Machinery and Equipment'
              ],
              [
                'isic_code' => '29',
                'description_th' => 'การผลิตเครื่องจักรกลและอุปกรณ์ที่มิได้ระบุไว้ที่อื่น',
                'description_en' => 'Manufacture of Machinery and Equipment N.E.C.'
              ],
              [
                'isic_code' => '30',
                'description_th' => 'การผลิตเครื่องใช้สำนักงาน เครื่องทำบัญชี และเครื่องคอมพิวเตอร์',
                'description_en' => 'Manufacture of Office, Accounting and Computing Machinery'
              ],
              [
                'isic_code' => '31',
                'description_th' => 'การผลิตเครื่องจักรกลและเครื่องมือไฟฟ้าที่มิได้ระบุไว้ที่อื่น',
                'description_en' => 'Manufacture of Electrical Machinery and Apparatus N.E.C.'
              ],
              [
                'isic_code' => '32',
                'description_th' => 'การผลิตวิทยุ โทรทัศน์ และอุปกรณ์และเครื่องมือในการคมนาคม',
                'description_en' => 'Manufacture of Radio, Television and Communication Equipment and Apparatus'
              ],
              [
                'isic_code' => '33',
                'description_th' => 'การผลิตเครื่องมือแพทย์ เครื่องมือเกี่ยวกับสายตา นาฬิกา',
                'description_en' => 'Manufacture of Medical, Precision and Optical Instruments, Watches and Clocks'
              ],
              [
                'isic_code' => '34',
                'description_th' => 'การผลิตยานยนต์ รถพ่วง และรถกึ่งพ่วง',
                'description_en' => 'Manufacture of Motor Vehicles, Trailers and Semi-Trailers'
              ],
              [
                'isic_code' => '35',
                'description_th' => 'การผลิตอุปกรณ์ขนส่งอื่น ๆ',
                'description_en' => 'Manufacture of Other Transport Equipment'
              ],
              [
                'isic_code' => '36',
                'description_th' => 'การผลิตเครื่องเรือน การผลิตที่มิได้ระบุไว้ที่อื่น',
                'description_en' => 'Manufacture of Furniture; Manufacturing N.E.C.'
              ],
              [
                'isic_code' => '37',
                'description_th' => 'การนำกลับมาใช้ใหม่',
                'description_en' => 'Recycling'
              ],
              [
                'isic_code' => '40',
                'description_th' => 'การจ่ายไฟฟ้า ก๊าซ ไอน้ำ และน้ำร้อน',
                'description_en' => 'Electricity, Gas, Steam and Hot Water Supply'
              ],
              [
                'isic_code' => '41',
                'description_th' => 'การเก็บน้ำ การกรองน้ำ และการจ่ายน้ำ',
                'description_en' => 'Collection, Purification and Distribution of Water'
              ],
              [
                'isic_code' => '45',
                'description_th' => 'การก่อสร้าง ',
                'description_en' => 'Construction'
              ],
              [
                'isic_code' => '50',
                'description_th' => 'การขาย การบำรุงรักษา และการซ้อมแซมยานยนต์และรถจักรยานยนต์ การขายปลีกน้ำมันเชื้อเพลิงรถยนต์',
                'description_en' => 'Sale, Maintenance and Repair of Motor Vehicles and Motorcycles; Retail Sale of Automotive Fuel'
              ],
              [
                'isic_code' => '51',
                'description_th' => 'การขายส่งและการค้าเพื่อค่านายหน้า ยกเว้นยานยนต์และรถจักรยานยนต์',
                'description_en' => 'Wholesale Trade and Commission Trade, Except of Motor Vehicles and Motorcycles'
              ],
              [
                'isic_code' => '52',
                'description_th' => 'การขายปลีก ยกเว้นยานยนต์และรถจักรยานยนต์ การซ่อมแซมของใช้ส่วนบุคคล และของใช้ภายในบ้าน',
                'description_en' => 'Retail Trade, Except of Motor Vehicles and Motorcycles; Repair of Personal and Household Goods'
              ],
              [
                'isic_code' => '55',
                'description_th' => 'โรงแรมและภัตตาคาร',
                'description_en' => 'Hotels and Restaurants'
              ],
              [
                'isic_code' => '60',
                'description_th' => 'การขนส่งทางบก การขนส่งทางท่อ',
                'description_en' => 'Land Transport; Transport via Pipelines'
              ],
              [
                'isic_code' => '61',
                'description_th' => 'การขนส่งทางน้ำ',
                'description_en' => 'Water Transport'
              ],
              [
                'isic_code' => '62',
                'description_th' => 'การขนส่งทางอากาศ',
                'description_en' => 'Air Transport'
              ],
              [
                'isic_code' => '63',
                'description_th' => 'กิจกรรมสนับสนุนและช่วยเหลือเกี่ยวกับการขนส่ง กิจกรรมของตัวแทนการท่องเที่ยว',
                'description_en' => 'Supporting and Auxiliary Transport Activities; Activities of Travel Agencies'
              ],
              [
                'isic_code' => '64',
                'description_th' => 'การไปรษณีย์และการโทรคมนาคม',
                'description_en' => 'Post and Telecommunications'
              ],
              [
                'isic_code' => '65',
                'description_th' => 'การเป็นตัวกลางทางการเงิน ยกเว้นการประกันภัยและกองทุนเลี้ยงชีพ',
                'description_en' => 'Financial Intermediation, Except Insurance and Pension Funding'
              ],
              [
                'isic_code' => '66',
                'description_th' => 'การประกันภัยและกองทุนเลี้ยงชีพ ยกเว้นการประกันสังคมแบบบังคับ ',
                'description_en' => 'Insurance and Pension Funding, Except Compulsory Social Security'
              ],
              [
                'isic_code' => '67',
                'description_th' => 'กิจกรรมตัวกลางสนับสนุนทางการเงิน',
                'description_en' => 'Activities Auxiliary to Financial Intermediation'
              ],
              [
                'isic_code' => '70',
                'description_th' => 'กิจกรรมด้านการค้าอสังหาริมทรัพย์',
                'description_en' => 'Real Estate Activities'
              ],
              [
                'isic_code' => '71',
                'description_th' => 'การให้เช่าเครื่องจักรและอุปกรณ์โดยไม่มีผู้ควบคุม การให้เช่าของใช้ส่วนบุคคลและของใช้ในบ้าน',
                'description_en' => 'Renting of Machiner and Equipment without Operator and of Personal and Household Goods'
              ],
              [
                'isic_code' => '72',
                'description_th' => 'คอมพิวเตอร์ และกิจกรรมที่เกี่ยวข้อง ',
                'description_en' => 'Computer and Related Activities'
              ],
              [
                'isic_code' => '73',
                'description_th' => 'การวิจัยและพัฒนา ',
                'description_en' => 'Research and Development'
              ],
              [
                'isic_code' => '74',
                'description_th' => 'กิจกรรมทางธุรกิจอื่น ๆ ',
                'description_en' => 'Other Business Activities'
              ],
              [
                'isic_code' => '75',
                'description_th' => 'การบริหารราชการและการป้องกันประเทศ การประกันสังคมแบบบังคับ',
                'description_en' => 'Public Administration and Defence; Compulsory Social Security'
              ],
              [
                'isic_code' => '80',
                'description_th' => 'การศึกษา ',
                'description_en' => 'Education'
              ],
              [
                'isic_code' => '85',
                'description_th' => 'การบริการเกี่ยวกับสุขภาพและสังคมสงเคราะห์ ',
                'description_en' => 'Health and Social Work'
              ],
              [
                'isic_code' => '90',
                'description_th' => 'การกำจัดน้ำเสีย การสุขาภิบาล และกิจกรรมอื่นที่คล้ายคลึงกัน',
                'description_en' => 'Sewage and Refuse Disposal, Sanitation and Similar Activities'
              ],
              [
                'isic_code' => '91',
                'description_th' => 'กิจกรรมขององค์กรสมาชิกที่มิได้ระบุไว้ที่อื่น',
                'description_en' => 'Activities Of Membership Organizations N.E.C.'
              ],
              [
                'isic_code' => '92',
                'description_th' => 'กิจกรรมนันทนาการ วัฒนธรรม และการกีฬา ',
                'description_en' => 'Recreational, Cultural and Sporting Activities'
              ],
              [
                'isic_code' => '93',
                'description_th' => 'กิจกรรมบริการอื่น ๆ ',
                'description_en' => 'Other Service Activities'
              ],
              [
                'isic_code' => '95',
                'description_th' => 'บ้านส่วนบุคคลพร้อมลูกจ้าง',
                'description_en' => 'Private Households with Employed Persons'
              ],
              [
                'isic_code' => '99',
                'description_th' => 'องค์การระหว่างประเทศและองค์การต่างประเทศอื่น ๆ และสมาชิก',
                'description_en' => 'Extra-Territorial Organizations and Bodies']
        ]);
    }
}
