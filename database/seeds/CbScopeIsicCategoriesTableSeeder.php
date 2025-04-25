<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeIsicCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_isic_categories')->insert([
            [
                "isic_id" => "1",
                "category_code" => "11",
                "description_th" => "การเพาะปลูก การทำสวน การเพาะพันธุ์พืช",
                "description_en" => "Growing of crops; market gardening; horticulture"
              ],
              [
                "isic_id" => "1",
                "category_code" => "12",
                "description_th" => "การทำปศุสัตว์",
                "description_en" => "Farming of animals"
              ],
              [
                "isic_id" => "1",
                "category_code" => "13",
                "description_th" => "การปลูกพืชร่วมกับการเลี้ยงสัตว์ (แบบผสม)",
                "description_en" => "Growing of crops combined with farming of animals (mixed farming)"
              ],
              [
                "isic_id" => "1",
                "category_code" => "14",
                "description_th" => "การบริการทางการเกษตร การสัตวบาล ยกเว้นการรักษาสัตว์",
                "description_en" => "Agricultural and animal husbandry service activities, except veterinary activities"
              ],
              [
                "isic_id" => "1",
                "category_code" => "15",
                "description_th" => "การล่าสัตว์ การดักสัตว์และการขยายพันธุ์สัตว์ล่า รวมทั้งบริการที่เกี่ยวข้อง ",
                "description_en" => "Hunting, trapping and game propagation including related service activities"
              ],
              [
                "isic_id" => "4",
                "category_code" => "101",
                "description_th" => "การทำเหมืองถ่านหินคุณภาพสูงและการอัดให้เป็นก้อน ",
                "description_en" => "Mining and agglomeration of hard coal"
              ],
              [
                "isic_id" => "4",
                "category_code" => "102",
                "description_th" => "การทำเหมืองลิกไนต์และการอัดให้เป็นก้อน",
                "description_en" => "Mining and agglomeration of lignite"
              ],
              [
                "isic_id" => "4",
                "category_code" => "103",
                "description_th" => "การขุดพีตและการอัดให้เป็นก้อน ",
                "description_en" => "Extraction and agglomeration of peat"
              ],
              [
                "isic_id" => "5",
                "category_code" => "111",
                "description_th" => "การขุดเจาะน้ำมันปิโตรเลียมและแก๊สธรรมชาติ ",
                "description_en" => "Extraction of crude petroleum and natural gas"
              ],
              [
                "isic_id" => "5",
                "category_code" => "112",
                "description_th" => "การให้บริการขุดเจาะน้ำมันและแก๊ส ยกเว้นการสำรวจ ",
                "description_en" => "Service activities incidental to oil and gas extraction excluding surveying"
              ],
              [
                "isic_id" => "7",
                "category_code" => "131",
                "description_th" => "การทำเหมืองแร่เหล็ก",
                "description_en" => "Mining of iron ores"
              ],
              [
                "isic_id" => "7",
                "category_code" => "132",
                "description_th" => "การทำเหมืองแร่โลหะที่ไม่ใช่เหล็ก ยกเว้นยูเรเนียมและ แร่ทอเรียม",
                "description_en" => "Mining of non-ferrous metal ores, except uranium and thorium ores"
              ],
              [
                "isic_id" => "8",
                "category_code" => "141",
                "description_th" => "การทำเหมืองหิน ทราย และดินเหนียว ",
                "description_en" => "Quarrying of stone, sand and clay"
              ],
              [
                "isic_id" => "8",
                "category_code" => "142",
                "description_th" => "การทำเหมืองแร่และเหมืองหินซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Mining and quarrying n.e.c."
              ],
              [
                "isic_id" => "9",
                "category_code" => "151",
                "description_th" => "การผลิต การแปรรูป และการเก็บถนอมเนื้อสัตว์ ปลา ผลไม้ ผัก น้ำมันและไขมัน ",
                "description_en" => "Production, processing and preservation of meat, fish, fruit, vegetables, oils and fats"
              ],
              [
                "isic_id" => "9",
                "category_code" => "152",
                "description_th" => "การผลิตผลิตภัณฑ์ที่ได้จากนม ",
                "description_en" => "Manufacture of dairy products"
              ],
              [
                "isic_id" => "9",
                "category_code" => "153",
                "description_th" => "การผลิตผลิตภัณฑ์จากธัญพืช สตาร์ช ผลิตภัณฑ์จากสตาร์ช และอาหารสัตว์สำเร็จรูป ",
                "description_en" => "Manufacture of graing mill products, starches and starch products, and prepared animal feeds"
              ],
              [
                "isic_id" => "9",
                "category_code" => "154",
                "description_th" => "การผลิตผลิตภัณฑ์อาหารอื่น ๆ ",
                "description_en" => "Manufacture of other food products"
              ],
              [
                "isic_id" => "9",
                "category_code" => "155",
                "description_th" => "การผลิตเครื่องดื่ม ",
                "description_en" => "Manufacture of beverages"
              ],
              [
                "isic_id" => "11",
                "category_code" => "171",
                "description_th" => "การปั่น การทอและการแต่งสำเร็จสิ่งทอสิ่งถัก",
                "description_en" => "Spinning, weaving and finishing of textiles"
              ],
              [
                "isic_id" => "11",
                "category_code" => "172",
                "description_th" => "การผลิตสิ่งทออื่น ๆ ",
                "description_en" => "Manufacture of other textiles"
              ],
              [
                "isic_id" => "11",
                "category_code" => "173",
                "description_th" => "การผลิตผ้าและสิ่งของที่ได้จากการถักนิตติงและโครเชต์",
                "description_en" => "Manufacture of knitted and crocheted fabrics and articles"
              ],
              [
                "isic_id" => "12",
                "category_code" => "181",
                "description_th" => "การผลิตเครื่องแต่งกาย ยกเว้นเครื่องแต่งกายที่ทำจากขนสัตว์ ",
                "description_en" => "Manufacture of wearing apparel, except fur apparel"
              ],
              [
                "isic_id" => "12",
                "category_code" => "182",
                "description_th" => "การตกแต่งและย้อมสีขนสัตว์ รวมทั้งการผลิตสิ่งของที่ทำจาก ขนสัตว์ ",
                "description_en" => "Dressing and dyeing of fur; manufacture of articles of fur"
              ],
              [
                "isic_id" => "13",
                "category_code" => "191",
                "description_th" => "การฟอกและการตกแต่งหนังสัตว์ รวมทั้งการผลิตกระเป๋า เดินทาง กระเป๋าถือ อานม้าและเครื่องลากเทียมสัตว์ ",
                "description_en" => "Tanning and dressing of leather; manufacture of luggage, handbags, saddlery and harness"
              ],
              [
                "isic_id" => "13",
                "category_code" => "192",
                "description_th" => "การผลิตรองเท้า ",
                "description_en" => "Manufacture of footwear"
              ],
              [
                "isic_id" => "14",
                "category_code" => "201",
                "description_th" => "การเลื่อยไม้และไสไม้ ",
                "description_en" => "Sawmilling and planing of wood"
              ],
              [
                "isic_id" => "14",
                "category_code" => "202",
                "description_th" => "การผลิตผลิตภัณฑ์จากไม้ ไม้ก๊อก ฟางและวัสดุถักสาน ",
                "description_en" => "Manufacture of products of wood, cork, straw and plaiting materials"
              ],
              [
                "isic_id" => "15",
                "category_code" => "210",
                "description_th" => "การผลิตกระดาษและผลิตภัณฑ์กระดาษ",
                "description_en" => "Manufacture of Paper and Paper Products"
              ],
              [
                "isic_id" => "16",
                "category_code" => "221",
                "description_th" => "การพิมพ์โฆษณา (Publishing) ",
                "description_en" => "Publishing"
              ],
              [
                "isic_id" => "16",
                "category_code" => "222",
                "description_th" => "การพิมพ์และกิจกรรมการบริการที่เกี่ยวข้องกับการพิมพ์ ",
                "description_en" => "Printing and service activities related to printing"
              ],
              [
                "isic_id" => "16",
                "category_code" => "223",
                "description_th" => "การพิมพ์และกิจกรรมการบริการที่เกี่ยวข้องกับการพิมพ์ ",
                "description_en" => "Printing and service activities related to printing"
              ],
              [
                "isic_id" => "17",
                "category_code" => "231",
                "description_th" => "การผลิตผลิตภัณฑ์ถ่านโค้ก\/ถ่านหิน",
                "description_en" => "Manufacture of coke oven products"
              ],
              [
                "isic_id" => "17",
                "category_code" => "232",
                "description_th" => "การผลิตผลิตภัณฑ์ที่ได้จากการกลั่นน้ำมันปิโตรเลียม",
                "description_en" => "Manufacture of refined petroleum products"
              ],
              [
                "isic_id" => "17",
                "category_code" => "233",
                "description_th" => "กระบวนการผลิตเชื้อเพลิงปรมาณู ",
                "description_en" => "Processing of nuclear fuel"
              ],
              [
                "isic_id" => "18",
                "category_code" => "241",
                "description_th" => "การผลิตเคมีภัณฑ์ขั้นมูลฐาน ",
                "description_en" => "Manufacture of basic chemicals"
              ],
              [
                "isic_id" => "18",
                "category_code" => "242",
                "description_th" => "การผลิตผลิตภัณฑ์เคมีอื่น ๆ ",
                "description_en" => "Manufacture of other chemical products"
              ],
              [
                "isic_id" => "18",
                "category_code" => "243",
                "description_th" => "การผลิตเส้นใยประดิษฐ์ ",
                "description_en" => "Manufacture of man-made fibres"
              ],
              [
                "isic_id" => "19",
                "category_code" => "251",
                "description_th" => "การผลิตผลิตภัณฑ์ยาง ",
                "description_en" => "Manufacture of rubber products"
              ],
              [
                "isic_id" => "19",
                "category_code" => "252",
                "description_th" => "การผลิตผลิตภัณฑ์พลาสติก ",
                "description_en" => "Manufacture of plastic products"
              ],
              [
                "isic_id" => "20",
                "category_code" => "261",
                "description_th" => "การผลิตแก้วและผลิตภัณฑ์จากแก้ว ",
                "description_en" => "Manufacture of glass and glass products"
              ],
              [
                "isic_id" => "20",
                "category_code" => "269",
                "description_th" => "การผลิตผลิตภัณฑ์จากแร่อโลหะ ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacture of non-metallic mineral products n.e.c."
              ],
              [
                "isic_id" => "21",
                "category_code" => "271",
                "description_th" => "การผลิตเหล็กและเหล็กกล้าขั้นมูลฐาน",
                "description_en" => "Manufacture of basic iron and steel"
              ],
              [
                "isic_id" => "21",
                "category_code" => "272",
                "description_th" => "การผลิตโลหะมีค่าและโลหะอื่นที่มิใช่เหล็กขั้นมูลฐาน",
                "description_en" => "Manufacture of basic precious and non-ferrous metals"
              ],
              [
                "isic_id" => "21",
                "category_code" => "273",
                "description_th" => "การหล่อโลหะ ",
                "description_en" => "Casing of metals"
              ],
              [
                "isic_id" => "22",
                "category_code" => "281",
                "description_th" => "การผลิตผลิตภัณฑ์ที่มีโครงสร้างเป็นโลหะ ภาชนะบรรจุ ขนาดใหญ่ และเครื่องกำเนิดไอน้ำ",
                "description_en" => "Manufacture of structural metal products, tanks, reservoirs and steam generators"
              ],
              [
                "isic_id" => "22",
                "category_code" => "289",
                "description_th" => "การผลิตผลิตภัณฑ์โลหะประดิษฐ์อื่น ๆ รวมทั้งกิจกรรมบริการ ที่เกี่ยวข้อง ",
                "description_en" => "Manufacture of other fabricated metal products; metal working service activities"
              ],
              [
                "isic_id" => "23",
                "category_code" => "291",
                "description_th" => "การผลิตเครื่องจักรที่ใช้งานทั่วไป ",
                "description_en" => "Manufacture of general purpose machinery"
              ],
              [
                "isic_id" => "23",
                "category_code" => "292",
                "description_th" => "การผลิตเครื่องจักรที่ใช้งานเฉพาะอย่าง",
                "description_en" => "Manufacture of special purpose machinery"
              ],
              [
                "isic_id" => "23",
                "category_code" => "293",
                "description_th" => "การผลิตเครื่องใช้ในบ้านเรือนอื่นๆ ซึ่งมิได้จัดประเภทไว้ ในที่อื่น ",
                "description_en" => "Manufacture of domestic appliances n.e.c."
              ],
              [
                "isic_id" => "25",
                "category_code" => "311",
                "description_th" => "การผลิตมอเตอร์ไฟฟ้า เครื่องกำเนิดไฟฟ้าและหม้อแปลงไฟฟ้า ",
                "description_en" => "Manufacture of electric motors, generators and transformers"
              ],
              [
                "isic_id" => "25",
                "category_code" => "312",
                "description_th" => "การผลิตเครื่องมือเพื่อการจ่ายและควบคุมกระแสไฟฟ้า ",
                "description_en" => "Manufacture of electricity distribution and control apparatus"
              ],
              [
                "isic_id" => "25",
                "category_code" => "313",
                "description_th" => "การผลิตลวดและเคเบิลหุ้มฉนวน ",
                "description_en" => "Manufacture of insulated wire and cable"
              ],
              [
                "isic_id" => "25",
                "category_code" => "314",
                "description_th" => "การผลิตหม้อแบตเตอรี่ไฟฟ้า เซลปฐมภูมิและแบตเตอรี่ปฐมภูมิ ",
                "description_en" => "Manufacture of accumulators, primary cells and primary batteries"
              ],
              [
                "isic_id" => "25",
                "category_code" => "315",
                "description_th" => "การผลิตหลอดไฟฟ้าและเครื่องอุปกรณ์สำหรับให้แสงสว่าง ",
                "description_en" => "Manufacture of electric lamps and lighting equipment"
              ],
              [
                "isic_id" => "25",
                "category_code" => "319",
                "description_th" => "การผลิตเครื่องมือเครื่องใช้ไฟฟ้า ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacture of other electrical equipment n.e.c."
              ],
              [
                "isic_id" => "26",
                "category_code" => "321",
                "description_th" => "การผลิตหลอดอิเล็กทรอนิกส์และส่วนประกอบอิเล็กทรอนิกส์อื่น ๆ ",
                "description_en" => "Manufacture of electronic valves and tubes and other electronic components"
              ],
              [
                "isic_id" => "26",
                "category_code" => "322",
                "description_th" => "การผลิตเครื่องส่งสัญญาณโทรทัศน์และวิทยุ และอุปกรณ์ สำหรับโทรศัพท์และโทรสารชนิดใช้สาย ",
                "description_en" => "Manufacture of television and radio transmitters and apparatus for line telephony and line telegraphy"
              ],
              [
                "isic_id" => "26",
                "category_code" => "323",
                "description_th" => "การผลิตเครื่องรับสัญญาณโทรทัศน์และวิทยุ เครื่องบันทึกเสียง หรือภาพ เครื่องซาวด์รีโพรดิวซิงหรือวีดิโอรีโพรดิวซิงและ สินค้าที่เกี่ยวข้อง ",
                "description_en" => "Manufacture of television and radio receivers, sound or video recording or reproducing apparatus, and associated goods"
              ],
              [
                "isic_id" => "27",
                "category_code" => "331",
                "description_th" => "การผลิตเครื่องมือทางการแพทย์และเครื่องมือที่ใช้ในการเดินเรือ การเดินอากาศ การวัด ตรวจสอบ ทดสอบ และวัตถุประสงค์อื่น ๆ ยกเว้นอุปกรณ์ที่ใช้ในทางทัศนศาสตร์ ",
                "description_en" => "Manufacture of medical appliances and instruments and appliances for measuring, checking, testing, navigating and other purposes, except optical instruments"
              ],
              [
                "isic_id" => "27",
                "category_code" => "332",
                "description_th" => "การผลิตอุปกรณ์ที่ใช้ในทางทัศนศาสตร์และอุปกรณ์ที่เกี่ยวกับ การถ่ายภาพ ",
                "description_en" => "Manufacture of optical instruments and photographic equipment"
              ],
              [
                "isic_id" => "27",
                "category_code" => "333",
                "description_th" => "การผลิตนาฬิกา ",
                "description_en" => "Manufacture of watches and clocks"
              ],
              [
                "isic_id" => "28",
                "category_code" => "341",
                "description_th" => "การผลิตยานยนต์และเครื่องยนต์ ",
                "description_en" => "Manufacture of motor vehicles"
              ],
              [
                "isic_id" => "28",
                "category_code" => "342",
                "description_th" => "การผลิตตัวถังยานยนต์ รวมทั้งการผลิตรถพ่วงและรถกึ่งรถพ่วง ",
                "description_en" => "Manufacture of bodies (coachwork) for motor vehicles; manufacture of trailers and semi-trailers"
              ],
              [
                "isic_id" => "28",
                "category_code" => "343",
                "description_th" => "การผลิตชิ้นส่วนและอุปกรณ์ประกอบสำหรับยานยนต์และ เครื่องยนต์ ",
                "description_en" => "Manufacture of parts and accessories for motor vehicles and their engines"
              ],
              [
                "isic_id" => "29",
                "category_code" => "351",
                "description_th" => "การต่อเรือและการซ่อมเรือ ",
                "description_en" => "Building and repairing of ships and boats"
              ],
              [
                "isic_id" => "29",
                "category_code" => "352",
                "description_th" => "การผลิตรถไฟ หัวรถจักร รถรางและอุปกรณ์รถไฟ ",
                "description_en" => "Manufacture of railway and tramway locomotives and rolling stock"
              ],
              [
                "isic_id" => "29",
                "category_code" => "353",
                "description_th" => "การผลิตอากาศยานและยานอวกาศ ",
                "description_en" => "Manufacture of aircraft and spacecraft"
              ],
              [
                "isic_id" => "29",
                "category_code" => "359",
                "description_th" => "การผลิตอุปกรณ์ขนส่งซึ่งมิได้จัดประเภทไว้ในที่อื่น",
                "description_en" => "Manufacture of transport equipment n.e.c."
              ],
              [
                "isic_id" => "30",
                "category_code" => "361",
                "description_th" => "การผลิตเครื่องเรือน ",
                "description_en" => "Manufacture of furniture"
              ],
              [
                "isic_id" => "30",
                "category_code" => "369",
                "description_th" => "การผลิตผลิตภัณฑ์ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacturing n.e.c."
              ],
              [
                "isic_id" => "31",
                "category_code" => "371",
                "description_th" => "การนำเศษโลหะและของที่ใช้ไม่ได้จำพวกโลหะมาผลิตเป็น วัตถุดิบใหม่ ",
                "description_en" => "Recycling of metal waste and scrap"
              ],
              [
                "isic_id" => "31",
                "category_code" => "372",
                "description_th" => "การนำเศษวัสดุที่มิใช่โลหะมาผลิตเป็นวัตถุดิบใหม่",
                "description_en" => "Recycling of non-metal waste and scrap"
              ],
              [
                "isic_id" => "32",
                "category_code" => "401",
                "description_th" => "การผลิตไฟฟ้า การเก็บและการจ่ายไฟฟ้า ",
                "description_en" => "Production, collection and distribution of electricity"
              ],
              [
                "isic_id" => "32",
                "category_code" => "402",
                "description_th" => "การผลิตแก๊สและการจ่ายเชื้อเพลิงชนิดแก๊สผ่านท่อ ",
                "description_en" => "Manufacture of gas; distribution of gaseous fuels through mains"
              ],
              [
                "isic_id" => "32",
                "category_code" => "403",
                "description_th" => "การจัดหาไอน้ำและน้ำร้อน ",
                "description_en" => "Steam and hot water supply"
              ],
              [
                "isic_id" => "34",
                "category_code" => "451",
                "description_th" => "การเตรียมสถานที่ก่อสร้าง",
                "description_en" => "Site preparation"
              ],
              [
                "isic_id" => "34",
                "category_code" => "452",
                "description_th" => "การก่อสร้างอาคาร และงานวิศวกรรมโยธา",
                "description_en" => "Building of complete constructions of parts thereof; civil engineering"
              ],
              [
                "isic_id" => "34",
                "category_code" => "453",
                "description_th" => "การติดตั้งภายในอาคาร ",
                "description_en" => "Building installation"
              ],
              [
                "isic_id" => "34",
                "category_code" => "454",
                "description_th" => "งานตกแต่งอาคารให้สมบูรณ์ ",
                "description_en" => "Building completion"
              ],
              [
                "isic_id" => "34",
                "category_code" => "455",
                "description_th" => "การให้เช่าเครื่องอุปกรณ์ที่ใช้ในงานก่อสร้างหรือรื้อถอน โดยมีผู้ควบคุม",
                "description_en" => "Renting of construction of demolition equipment with operator"
              ],
              [
                "isic_id" => "35",
                "category_code" => "501",
                "description_th" => "การขายยานยนต์ ",
                "description_en" => "Sale of motor vehicles"
              ],
              [
                "isic_id" => "35",
                "category_code" => "502",
                "description_th" => "การบำรุงรักษาและการซ่อมแซมยานยนต์ ",
                "description_en" => "Maintenance and repair of motor vehicles"
              ],
              [
                "isic_id" => "35",
                "category_code" => "503",
                "description_th" => "การขายอะไหล่และชิ้นส่วนอุปกรณ์ยานยนต์ ",
                "description_en" => "Sale of motor vehicle parts and accessories"
              ],
              [
                "isic_id" => "35",
                "category_code" => "504",
                "description_th" => "การขายจักรยานยนต์ อะไหล่และชิ้นส่วนอุปกรณ์ที่เกี่ยวข้อง และการบำรุงรักษาและการซ่อมแซมจักรยานยนต์ ",
                "description_en" => "Sale, maintenance and repair of motorcycles and related parts and accessories"
              ],
              [
                "isic_id" => "35",
                "category_code" => "505",
                "description_th" => "การขายปลีกน้ำมันเชื้อเพลิง (สถานีน้ำมัน) ",
                "description_en" => "Retail sale of automotive fuel"
              ],
              [
                "isic_id" => "36",
                "category_code" => "511",
                "description_th" => "การขายส่งโดยได้รับค่าธรรมเนียม หรือโดยการทำสัญญา",
                "description_en" => "Wholesale on a fee or contract basis"
              ],
              [
                "isic_id" => "36",
                "category_code" => "512",
                "description_th" => "การขายส่งวัตถุดิบทางการเกษตร สัตว์ที่มีชีวิต อาหาร เครื่องดื่ม และยาสูบ ",
                "description_en" => "Wholesale of agricultural raw materials, live animals, food, beverages and tobacco"
              ],
              [
                "isic_id" => "36",
                "category_code" => "513",
                "description_th" => "การขายส่งสินค้าที่ใช้ในครัวเรือน",
                "description_en" => "Wholesale of household goods"
              ],
              [
                "isic_id" => "36",
                "category_code" => "514",
                "description_th" => "การขายส่งสินค้าขั้นกลางที่มิใช่สินค้าทางการเกษตร และ ของที่ไม่ใช้แล้ว ",
                "description_en" => "Wholesale of non-agricultural intermediate products, waste and scrap"
              ],
              [
                "isic_id" => "36",
                "category_code" => "515",
                "description_th" => "การขายส่งเครื่องจักร อุปกรณ์เครื่องจักรและเครื่องมือเครื่องใช้ ",
                "description_en" => "Wholesale of machinery, equipment and supplies"
              ],
              [
                "isic_id" => "36",
                "category_code" => "519",
                "description_th" => "การขายส่งสินค้าหลายชนิด ",
                "description_en" => "Other wholesale"
              ],
              [
                "isic_id" => "37",
                "category_code" => "521",
                "description_th" => "การขายปลีกสินค้าทั่วไปในร้านค้า",
                "description_en" => "Non-specialized retail trade in stores"
              ],
              [
                "isic_id" => "37",
                "category_code" => "522",
                "description_th" => "การขายปลีกอาหาร เครื่องดื่ม และยาสูบในร้านเฉพาะอย่าง สินค้าประเภทนั้น ๆ ",
                "description_en" => "Retail sale of food, beverages and tobacco in specialized stores"
              ],
              [
                "isic_id" => "37",
                "category_code" => "523",
                "description_th" => "การขายปลีกสินค้าใหม่ในร้านค้าเฉพาะอย่างของสินค้านั้น ๆ ",
                "description_en" => "Other retail trade of new goods in specialized stores"
              ],
              [
                "isic_id" => "37",
                "category_code" => "524",
                "description_th" => "การขายปลีกของใช้แล้ว หรือของเก่าในร้านค้า ",
                "description_en" => "Retail sale of second-hand goods in stores"
              ],
              [
                "isic_id" => "37",
                "category_code" => "525",
                "description_th" => "การขายปลีกนอกร้านค้า ",
                "description_en" => "Retail trade not in stores"
              ],
              [
                "isic_id" => "37",
                "category_code" => "526",
                "description_th" => "การซ่อมของใช้ส่วนบุคคล และของใช้ในครัวเรือน",
                "description_en" => "Repair of personal and household goods"
              ],
              [
                "isic_id" => "38",
                "category_code" => "551",
                "description_th" => "โรงแรม ค่ายพัก และที่พักชั่วคราว",
                "description_en" => "Hotels; camping sites and other provision of short-stay accommodation"
              ],
              [
                "isic_id" => "38",
                "category_code" => "552",
                "description_th" => "ภัตตาคาร ร้านขายอาหาร และบาร์ ",
                "description_en" => "Restaurants, bars and canteens"
              ],
              [
                "isic_id" => "39",
                "category_code" => "601",
                "description_th" => "การขนส่งทางรถไฟ",
                "description_en" => "Transport via railways"
              ],
              [
                "isic_id" => "39",
                "category_code" => "602",
                "description_th" => "การขนส่งทางบกอื่น ๆ ",
                "description_en" => "Other land transport"
              ],
              [
                "isic_id" => "39",
                "category_code" => "603",
                "description_th" => "การขนส่งทางระบบท่อลำเลียง ",
                "description_en" => "Transport via pipelines"
              ],
              [
                "isic_id" => "40",
                "category_code" => "611",
                "description_th" => "การขนส่งทางทะเลและทะเลชายฝั่ง ",
                "description_en" => "Sea and coastal water transport"
              ],
              [
                "isic_id" => "40",
                "category_code" => "612",
                "description_th" => "การขนส่งทางน้ำภายในประเทศ ",
                "description_en" => "Inland water transport"
              ],
              [
                "isic_id" => "41",
                "category_code" => "621",
                "description_th" => "การขนส่งทางอากาศที่มีตารางเวลา ",
                "description_en" => "Scheduled air transport"
              ],
              [
                "isic_id" => "41",
                "category_code" => "622",
                "description_th" => "การขนส่งทางอากาศที่ไม่มีตารางเวลา",
                "description_en" => "Non-scheduled air transport"
              ],
              [
                "isic_id" => "42",
                "category_code" => "630",
                "description_th" => "กิจกรรมสนับสนุนและช่วยเหลือเกี่ยวกับการขนส่ง กิจกรรมของตัวแทนการท่องเที่ยว",
                "description_en" => "Supporting and Auxiliary Transport Activities; Activities of Travel Agencies"
              ],
              [
                "isic_id" => "43",
                "category_code" => "641",
                "description_th" => "บริการทางไปรษณีย์และการรับส่งพัสดุภัณฑ์ ",
                "description_en" => "Post and courier activities"
              ],
              [
                "isic_id" => "43",
                "category_code" => "642",
                "description_th" => "การโทรคมนาคม ",
                "description_en" => "Telecommunications"
              ],
              [
                "isic_id" => "44",
                "category_code" => "651",
                "description_th" => "การเป็นตัวกลางทางเงินตรา",
                "description_en" => "Finacial Institution (Banking)"
              ],
              [
                "isic_id" => "44",
                "category_code" => "659",
                "description_th" => "การเป็นตัวกลางทางการเงินอื่น ๆ ",
                "description_en" => "Other financial intermediation"
              ],
              [
                "isic_id" => "45",
                "category_code" => "660",
                "description_th" => "การประกันภัยและกองทุนเลี้ยงชีพ ยกเว้นการประกันสังคมแบบบังคับ ",
                "description_en" => "Insurance and Pension Funding, Except Compulsory Social Security"
              ],
              [
                "isic_id" => "46",
                "category_code" => "671",
                "description_th" => "กิจกรรมตัวกลางสนับสนุนทางการเงินยกเว้นการประกันภัยและกองทุนเลี้ยงชีพ",
                "description_en" => "Activities auxiliary to financial intermediation, except insurance and pension funding"
              ],
              [
                "isic_id" => "46",
                "category_code" => "672",
                "description_th" => "กิจกรรมตัวกลางสนับสนุนทางประกันภัยและกองทุนเลี้ยงชีพ",
                "description_en" => "Activities auxiliary to insurance and pension funding"
              ],
              [
                "isic_id" => "47",
                "category_code" => "701",
                "description_th" => "การให้เช่าหรือการให้เช่าช่วงอสังหาริมทรัพย์",
                "description_en" => "Real estate activities with own or leased property"
              ],
              [
                "isic_id" => "47",
                "category_code" => "702",
                "description_th" => "กิจกรรมกด้านการค้าอสังหาริมทรัพย์โดยคิดว่าตอบแทนเป็นครั้งคราวหรือตามสัญญา",
                "description_en" => "Real estate activities on a fee or contract basis"
              ],
              [
                "isic_id" => "48",
                "category_code" => "711",
                "description_th" => "การให้เช่าอุปกรณ์ขนส่ง ",
                "description_en" => "Renting of transport equipment"
              ],
              [
                "isic_id" => "48",
                "category_code" => "712",
                "description_th" => "การให้เช่าเครื่องจักรและอุปกรณ์อื่น ๆ ",
                "description_en" => "Renting of other machinery and equipment"
              ],
              [
                "isic_id" => "48",
                "category_code" => "713",
                "description_th" => "การให้เช่าของใช้ส่วนบุคคลและของใช้ภายในบ้านที่มิได้ระบุไว้ที่อื่น ",
                "description_en" => "Renting of personal and household goods n.e.c."
              ],
              [
                "isic_id" => "49",
                "category_code" => "721",
                "description_th" => "การให้คำปรึกษาเกี่ยวกับฮาร์ดแวร์ ",
                "description_en" => "Hardware consultancy"
              ],
              [
                "isic_id" => "49",
                "category_code" => "722",
                "description_th" => "การให้คำปรึกษาและจัดหาซอฟต์แวร์ ",
                "description_en" => "Software consultancy and supply"
              ],
              [
                "isic_id" => "49",
                "category_code" => "723",
                "description_th" => "การประมวลผลข้อมูล ",
                "description_en" => "Data processing"
              ],
              [
                "isic_id" => "49",
                "category_code" => "724",
                "description_th" => "กิจกรรมฐานข้อมูล ",
                "description_en" => "Data base activities"
              ],
              [
                "isic_id" => "49",
                "category_code" => "725",
                "description_th" => "การบำรุงรักษาและการซ่อมแซมเครื่องจักรสำนักงาน เครื่องทำบัญชี และเครื่องคอมพิวเตอร์",
                "description_en" => "Maintenance and repair of office, accounting and computing machinery"
              ],
              [
                "isic_id" => "49",
                "category_code" => "729",
                "description_th" => "กิจกรรมอื่น ๆที่เกี่ยวข้องกับคอมพิวเตอร์ ",
                "description_en" => "Other computer related activities"
              ],
              [
                "isic_id" => "50",
                "category_code" => "731",
                "description_th" => "การวิจัยและการพัฒนาการทดลองด้านวิทยาศาสตร์ ธรรมชาติและวิศวกรรม ",
                "description_en" => "Research and experimental development on natural sciences and engineering (NSE)"
              ],
              [
                "isic_id" => "50",
                "category_code" => "732",
                "description_th" => "การวิจัยและพัฒนาการทดลองด้านสังคมศาสตร์ และมนุษยวิทยา",
                "description_en" => "Research and experimental development on social sciences and humanities (SSH)"
              ],
              [
                "isic_id" => "51",
                "category_code" => "741",
                "description_th" => "การให้บริการทางกฎหมาย การทำบัญชี การตรวจสอบบัญชี การให้คำปรึกษาเกี่ยวกับภาษีอากร การวิจัยทางการตลาด การสำรวจประชามติ การบริการให้คำปรึกษาทางธุรกิจและการจัดการ",
                "description_en" => "Legal, accounting, book-keeping and auditing activities; tax consultancy; market research and public opinion polling; business and management consultancy"
              ],
              [
                "isic_id" => "51",
                "category_code" => "742",
                "description_th" => "การบริการให้คำรปรึกษาทางสถาปัตยกรรม วิศวกรรม และกิจกรรมทางเทคนิคอื่น ๆ",
                "description_en" => "Architectural, engineering and other technical activities"
              ],
              [
                "isic_id" => "51",
                "category_code" => "743",
                "description_th" => "การบริการให้คำรปรึกษาทางสถาปัตยกรรม วิศวกรรม และกิจกรรมทางเทคนิคอื่น ๆ",
                "description_en" => "Architectural, engineering and other technical activities"
              ],
              [
                "isic_id" => "51",
                "category_code" => "749",
                "description_th" => "การบริการให้คำรปรึกษาทางสถาปัตยกรรม วิศวกรรม และกิจกรรมทางเทคนิคอื่น ๆ",
                "description_en" => "Business activities n.e.c."
              ],
              [
                "isic_id" => "52",
                "category_code" => "751",
                "description_th" => "การให้บริหารราชการและการบริการทางสังคม",
                "description_en" => "Administration of the State and the economic and social policy of the community"
              ],
              [
                "isic_id" => "52",
                "category_code" => "752",
                "description_th" => "การบริการต่อชุมชนโดยรวม ",
                "description_en" => "Provision of services to the community as a whole"
              ],
              [
                "isic_id" => "52",
                "category_code" => "753",
                "description_th" => "กิจกรรมการประกันสังคมแบบบังคับ ",
                "description_en" => "Compulsory social security activities"
              ],
              [
                "isic_id" => "53",
                "category_code" => "801",
                "description_th" => "การศึกษาระดับประถม",
                "description_en" => "Primary education"
              ],
              [
                "isic_id" => "53",
                "category_code" => "802",
                "description_th" => "การศึกษาระดับมัธยม",
                "description_en" => "Secondary education"
              ],
              [
                "isic_id" => "53",
                "category_code" => "803",
                "description_th" => "การศึกษาขั้นสูง",
                "description_en" => "Higher education"
              ],
              [
                "isic_id" => "53",
                "category_code" => "809",
                "description_th" => "การศึกษาระดับผู้ใหญ่และอื่น ๆ ",
                "description_en" => "Adult and other education"
              ],
              [
                "isic_id" => "54",
                "category_code" => "851",
                "description_th" => "การบริการเกี่ยวกับสุขภาพคน",
                "description_en" => "Human health activities"
              ],
              [
                "isic_id" => "54",
                "category_code" => "852",
                "description_th" => "การรักษาสัตว์ ",
                "description_en" => "Veterinary activities"
              ],
              [
                "isic_id" => "54",
                "category_code" => "853",
                "description_th" => "การสังคมสงเคราะห์ ",
                "description_en" => "Social work activities"
              ],
              [
                "isic_id" => "56",
                "category_code" => "911",
                "description_th" => "กิจกรรมขององค์กรทางธุรกิจ องค์กรนายจ้าง และองค์กรทางวิชาชีพ",
                "description_en" => "Activities of business, employers and professional organization"
              ],
              [
                "isic_id" => "56",
                "category_code" => "912",
                "description_th" => "กิจกรรมความร่วมมือทางการค้า",
                "description_en" => "Activities of trade unions"
              ],
              [
                "isic_id" => "56",
                "category_code" => "919",
                "description_th" => "กิจกรรมขององค์กรสมาชิกอื่น ๆ",
                "description_en" => "Activities of other membership organizations"
              ],
              [
                "isic_id" => "57",
                "category_code" => "921",
                "description_th" => "ภาพยนตร์ วิทยุ โทรทัศน์ และกิจกรรมบันเทิงอื่น ๆ",
                "description_en" => "Motion picture, radio, television and other entertainment activities"
              ],
              [
                "isic_id" => "57",
                "category_code" => "922",
                "description_th" => "กิจกรรมบันเทิงอื่น ๆ ที่มิได้ระบุไว้ทื่อื่น",
                "description_en" => "News agency activities"
              ],
              [
                "isic_id" => "57",
                "category_code" => "923",
                "description_th" => "ห้องสมุด สถานที่เก็บเอกสารสำคัญ พิพิธภัณฑ์และกิจกรรมทางด้านวัฒนธรรมอื่น ๆ",
                "description_en" => "Library, archives, museums and other cultural activities"
              ],
              [
                "isic_id" => "57",
                "category_code" => "924",
                "description_th" => "การกีฬา และกิจกรรมนันทนาการอื่น ๆ",
                "description_en" => "Sporting and other recreational activities"
              ],
              [
                "isic_id" => "58",
                "category_code" => "930",
                "description_th" => "กิจกรรมบริการอื่น ๆ ",
                "description_en" => "Other Service Activities"]
        ]);

    }
}
