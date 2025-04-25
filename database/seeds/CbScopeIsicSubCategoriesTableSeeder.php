<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbScopeIsicSubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cb_scope_isic_sub_categories')->insert([
            [
                "category_id" => "1",
                "sub_category_code" => "111",
                "description_th" => "การเพาะปลูกธัญพืชและพืชผลอื่น ๆ ที่มิได้ระบุไว้ที่อื่น",
                "description_en" => "Growing of cereals and other crops n.e.c."
              ],
              [
                "category_id" => "1",
                "sub_category_code" => "112",
                "description_th" => "การปลูกผัก การเพราะปลูกพืชพิเศษและพืชในเรือนเพาะชำ",
                "description_en" => "Growing of vegetables, horticultural specialties and nursery products"
              ],
              [
                "category_id" => "1",
                "sub_category_code" => "113",
                "description_th" => "การทำสวนผลไม้ ผลไม้เปลืองแข็ง พืชที่ใช้ทำเครื่อง และเครื่องเทศ",
                "description_en" => "Growing of fruit, nuts, beverage and spice crops"
              ],
              [
                "category_id" => "2",
                "sub_category_code" => "121",
                "description_th" => "การเลี้ยงโค กระบือ แพะ แกะ ม้า ลาและล่อ",
                "description_en" => "Farming of cattle, sheep, goats, horses, asses, mules and hinnies; dairy farming"
              ],
              [
                "category_id" => "2",
                "sub_category_code" => "122",
                "description_th" => "การเลี้ยงสัตว์ปีกและสัตว์อื่น ๆ รวมทั้งการผลิตผลิตภัณฑ์ จากสัตว์ ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Other animal farming; production of animal products n.e.c."
              ],
              [
                "category_id" => "14",
                "sub_category_code" => "1421",
                "description_th" => "การทำเหมืองแร่ที่ใช้ทำเคมีภัณฑ์และปุ๋ย ",
                "description_en" => "Mining of chemical and fertilizer minerals"
              ],
              [
                "category_id" => "14",
                "sub_category_code" => "1422",
                "description_th" => "การทำเหมืองเกลือ ",
                "description_en" => "Extraction of salt"
              ],
              [
                "category_id" => "14",
                "sub_category_code" => "1429",
                "description_th" => "การทำเหมืองแร่และเหมืองหินอื่นๆ ซึ่งมิได้จัดประเภท ไว้ในที่อื่น",
                "description_en" => "Other mining and quarrying n.e.c."
              ],
              [
                "category_id" => "15",
                "sub_category_code" => "1511",
                "description_th" => "การผลิต การแปรรูปและการเก็บถนอมเนื้อสัตว์และ ผลิตภัณฑ์เนื้อสัตว์ ",
                "description_en" => "Production, processing and preserving of meat and meat products"
              ],
              [
                "category_id" => "15",
                "sub_category_code" => "1512",
                "description_th" => "การแปรรูปและและการเก็บถนอมสัตว์น้ำและผลิตภัณฑ์สัตว์น้ำ ",
                "description_en" => "Processing and preserving of fish and fish products"
              ],
              [
                "category_id" => "15",
                "sub_category_code" => "1513",
                "description_th" => "การแปรรูปและการเก็บถนอมผลไม้และผัก ",
                "description_en" => "Processing and preserving of fruit and vegetables"
              ],
              [
                "category_id" => "15",
                "sub_category_code" => "1514",
                "description_th" => "การผลิตน้ำมันพืช น้ำมันและไขมันจากสัตว์ ",
                "description_en" => "Manufacture of vegetable and animal oils and fats"
              ],
              [
                "category_id" => "17",
                "sub_category_code" => "1531",
                "description_th" => "การผลิตผลิตภัณฑ์จากธัญพืช ",
                "description_en" => "Manufacture of graing mill products"
              ],
              [
                "category_id" => "17",
                "sub_category_code" => "1532",
                "description_th" => "การผลิตสตาร์ชและผลิตภัณฑ์จากสตาร์ช",
                "description_en" => "Manufacture of starches and starch products"
              ],
              [
                "category_id" => "17",
                "sub_category_code" => "1533",
                "description_th" => "การผลิตอาหารสัตว์สำเร็จรูป ",
                "description_en" => "Manufacture of prepared animal feeds"
              ],
              [
                "category_id" => "18",
                "sub_category_code" => "1541",
                "description_th" => "การผลิตผลิตภัณฑ์ขนมปัง ",
                "description_en" => "Manufacture of bakery products"
              ],
              [
                "category_id" => "18",
                "sub_category_code" => "1542",
                "description_th" => "การผลิตน้ำตาล ",
                "description_en" => "Manufacture of sugar"
              ],
              [
                "category_id" => "18",
                "sub_category_code" => "1543",
                "description_th" => "การผลิตโกโก้ ช็อกโกแลตและขนมชนิดเคลือบและ มีไส้เป็นน้ำตาล ",
                "description_en" => "Manufacture of cocoa, chocolate and sugar confectionery"
              ],
              [
                "category_id" => "18",
                "sub_category_code" => "1544",
                "description_th" => "การผลิตมักกะโรนี เส้นก๋วยเตี๋ยว เส้นบะหมี่ เส้นหมี่ วุ้นเส้นและผลิตภัณฑ์อาหารจำพวกแป้งที่คล้ายคลึงกัน ",
                "description_en" => "Manufacture of macaroni, noodles, couscous and similar farinaceous products"
              ],
              [
                "category_id" => "18",
                "sub_category_code" => "1549",
                "description_th" => "การผลิตผลิตภัณฑ์อาหารอื่น ซึ่งมิได้จัดประเภทไว้ในที่อื่น",
                "description_en" => "Manufacture of other food products n.e.c."
              ],
              [
                "category_id" => "19",
                "sub_category_code" => "1551",
                "description_th" => "การต้ม การกลั่นและการผสมสุรา การผลิตเอทิลแอลกอฮอล์ ที่ได้จากการหมัก",
                "description_en" => "Distilling, rectifying and blending of spirits; ethyl alcohol production from fermented materials"
              ],
              [
                "category_id" => "19",
                "sub_category_code" => "1552",
                "description_th" => "การผลิตสุราผลไม้ (ไวน์) ",
                "description_en" => "Manufacture of wines"
              ],
              [
                "category_id" => "19",
                "sub_category_code" => "1553",
                "description_th" => "การผลิตมอลต์ และสุราที่ทำจากข้าวมอลต์ ",
                "description_en" => "Manufacture of malt liquors and malt"
              ],
              [
                "category_id" => "19",
                "sub_category_code" => "1554",
                "description_th" => "การผลิตเครื่องดื่มที่ไม่มีแอลกอฮอล์และการผลิตน้ำแร่ ",
                "description_en" => "Manufacture of soft drinks; production of mineral waters"
              ],
              [
                "category_id" => "20",
                "sub_category_code" => "1711",
                "description_th" => "การจัดเตรียมและการปั่นเส้นใยสิ่งทอ รวมทั้งการทอสิ่งทอ ",
                "description_en" => "Preparation and spinning of textile fibres; weaving of textiles"
              ],
              [
                "category_id" => "20",
                "sub_category_code" => "1712",
                "description_th" => "การแต่งสำเร็จสิ่งทอ ",
                "description_en" => "Finishing of textiles"
              ],
              [
                "category_id" => "21",
                "sub_category_code" => "1721",
                "description_th" => "การผลิตสิ่งทอสำเร็จรูป ยกเว้นเครื่องแต่งกาย ",
                "description_en" => "Manufacture of made-up textile articles, except apparel"
              ],
              [
                "category_id" => "21",
                "sub_category_code" => "1722",
                "description_th" => "การผลิตพรมและเครื่องปูลาด ",
                "description_en" => "Manufacture of carpets and rugs"
              ],
              [
                "category_id" => "21",
                "sub_category_code" => "1723",
                "description_th" => "การผลิตเชือก สายระโยงระยาง เชือกเส้นใหญ่ ตาข่าย แหและอวน ",
                "description_en" => "Manufacture of cordage, rope, twine and netting"
              ],
              [
                "category_id" => "21",
                "sub_category_code" => "1729",
                "description_th" => "การผลิตสิ่งทออื่น ๆ ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacture of other textiles n.e.c."
              ],
              [
                "category_id" => "25",
                "sub_category_code" => "1911",
                "description_th" => "การฟอกและการตกแต่งหนังสัตว์ ",
                "description_en" => "Tanning and dressing of leather"
              ],
              [
                "category_id" => "25",
                "sub_category_code" => "1912",
                "description_th" => "การผลิตกระเป๋าเดินทาง กระเป๋าถือ ผลิตภัณฑ์ที่คล้ายคลึงกัน และเครื่องลากเทียมสัตว์ ",
                "description_en" => "Manufacture of luggage, handbags and the like, saddlery and harness"
              ],
              [
                "category_id" => "28",
                "sub_category_code" => "2021",
                "description_th" => "การผลิตแผ่นไม้บาง แผ่นไม้อัด ไม้ประสาน แผ่นชิ้นไม้อัด แผ่นกระดานและแผ่นไม้อื่น ๆ ",
                "description_en" => "Manufacture of veneer sheets; manufacture of plywood, laminboard, particle board and other panels and boards"
              ],
              [
                "category_id" => "28",
                "sub_category_code" => "2022",
                "description_th" => "การผลิตเครื่องไม้ที่ใช้ในการก่อสร้างและเครื่องประกอบ อาคาร ",
                "description_en" => "Manufacture of builders' carpentry and joinery"
              ],
              [
                "category_id" => "28",
                "sub_category_code" => "2023",
                "description_th" => "การผลิตภาชนะไม้ ",
                "description_en" => "Manufacture of wooden containers"
              ],
              [
                "category_id" => "28",
                "sub_category_code" => "2029",
                "description_th" => "การผลิตผลิตภัณฑ์อื่น ๆ จากไม้ ไม้ก๊อก ฟางและวัสดุถักสาน ยกเว้นเครื่องเรือน ",
                "description_en" => "Manufacture of other products of wood; manufacture of articles of cork, straw and plaiting materials"
              ],
              [
                "category_id" => "29",
                "sub_category_code" => "2101",
                "description_th" => "การผลิตเยื่อกระดาษ กระดาษและกระดาษแข็ง ",
                "description_en" => "Manufacture of pulp, paper and paperboard"
              ],
              [
                "category_id" => "29",
                "sub_category_code" => "2102",
                "description_th" => "การผลิตกระดาษลูกฟูกและภาชนะบรรจุที่ทำจากกระดาษ และกระดาษแข็ง ",
                "description_en" => "Manufacture of corrugated paper and paperboard"
              ],
              [
                "category_id" => "29",
                "sub_category_code" => "2109",
                "description_th" => "การผลิตผลิตภัณฑ์อื่น ๆ ที่ทำจากกระดาษและกระดาษแข็ง ",
                "description_en" => "Manufacture of other articles of paper and paperboard"
              ],
              [
                "category_id" => "30",
                "sub_category_code" => "2211",
                "description_th" => "การพิมพ์โฆษณาหนังสือ โบรชัวร์ หนังสือที่เกี่ยวกับดนตรี และสิ่งพิมพ์อื่น ๆ ",
                "description_en" => "Publishing of books, brochures, musical books and other publications"
              ],
              [
                "category_id" => "30",
                "sub_category_code" => "2212",
                "description_th" => "การพิมพ์โฆษณาหนังสือพิมพ์ วารสาร และนิตยสาร ",
                "description_en" => "Publishing of newspapers, journals and periodicals"
              ],
              [
                "category_id" => "30",
                "sub_category_code" => "2213",
                "description_th" => "การพิมพ์โฆษณาสื่อบันทึก (Recorded Media) ",
                "description_en" => "Publishing of recorded media"
              ],
              [
                "category_id" => "30",
                "sub_category_code" => "2219",
                "description_th" => "การพิมพ์โฆษณาอื่น ๆ",
                "description_en" => "Other publishing"
              ],
              [
                "category_id" => "31",
                "sub_category_code" => "2221",
                "description_th" => "การพิมพ์ (Printing) ",
                "description_en" => "Printing"
              ],
              [
                "category_id" => "31",
                "sub_category_code" => "2222",
                "description_th" => "กิจกรรมด้านการบริการที่เกี่ยวข้องกับการพิมพ์ ",
                "description_en" => "Service activities related to printing"
              ],
              [
                "category_id" => "36",
                "sub_category_code" => "2411",
                "description_th" => "การผลิตเคมีภัณฑ์ขั้นมูลฐาน ยกเว้นปุ๋ยและสารประกอบ ไนโตรเจน ",
                "description_en" => "Manufacture of basic chemicals, except fertilizers and nitrogen compounds"
              ],
              [
                "category_id" => "36",
                "sub_category_code" => "2412",
                "description_th" => "การผลิตปุ๋ยและสารประกอบไนโตรเจน ",
                "description_en" => "Manufacture of fertilizers and nitrogen compounds"
              ],
              [
                "category_id" => "36",
                "sub_category_code" => "2413",
                "description_th" => "การผลิตพลาสติกในขั้นต้นและยางสังเคราะห์ ",
                "description_en" => "Manufacture of plastics in primary forms and of synthetic rubber"
              ],
              [
                "category_id" => "37",
                "sub_category_code" => "2421",
                "description_th" => "การผลิตยาปราบศัตรูพืช และผลิตภัณฑ์เคมีทางเกษตรอื่น ๆ ",
                "description_en" => "Manufacture of pesticides and other agro-chemical products"
              ],
              [
                "category_id" => "37",
                "sub_category_code" => "2422",
                "description_th" => "การผลิตสีทา น้ำมันชักเงา สารเคลือบต่าง ๆ หมึกพิมพ์และ น้ำมันทาไม้ ",
                "description_en" => "Manufacture of paints, varnishes and similar coatings, printing ink and mastics"
              ],
              [
                "category_id" => "37",
                "sub_category_code" => "2423",
                "description_th" => "การผลิตผลิตภัณฑ์ทางเภสัชกรรม เคมีภัณฑ์รักษาโรคและ ผลิตภัณฑ์จากสมุนไพร ",
                "description_en" => "Manufacture of pharmaceuticals, medicinal chemicals and botanical products"
              ],
              [
                "category_id" => "37",
                "sub_category_code" => "2424",
                "description_th" => "การผลิตสบู่ ผงซักฟอก เคมีภัณฑ์ที่ใช้ทำความสะอาดและ ขัดเงา น้ำหอมและเครื่องหอมอื่น ๆ ",
                "description_en" => "Manufacture of soap and detergents, cleaning and polishing preparations, perfumes and toilet preparations"
              ],
              [
                "category_id" => "37",
                "sub_category_code" => "2429",
                "description_th" => "การผลิตผลิตภัณฑ์เคมี ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacture of other chemical products n.e.c."
              ],
              [
                "category_id" => "39",
                "sub_category_code" => "2511",
                "description_th" => "การผลิตยางนอก ยางใน การหล่อดอกยางและการซ่อมสร้าง ยางใหม่ ",
                "description_en" => "Manufacture of rubber tyres and tubes; retreading and rebuilding of rubber tyres"
              ],
              [
                "category_id" => "39",
                "sub_category_code" => "2519",
                "description_th" => "การผลิตผลิตภัณฑ์ยางอื่น ๆ ",
                "description_en" => "Manufacture of other rubber products"
              ],
              [
                "category_id" => "42",
                "sub_category_code" => "2691",
                "description_th" => "การผลิตผลิตภัณฑ์เซรามิกชนิดไม่ทนไฟ ซึ่งไม่ได้ใช้ในงาน ก่อสร้าง ",
                "description_en" => "Manufacture of non-structural non-refractory ceramic ware"
              ],
              [
                "category_id" => "42",
                "sub_category_code" => "2692",
                "description_th" => "การผลิตผลิตภัณฑ์เซรามิกทนไฟ ",
                "description_en" => "Manufacture of refractory ceramic products"
              ],
              [
                "category_id" => "42",
                "sub_category_code" => "2693",
                "description_th" => "การผลิตผลิตภัณฑ์จากดินชนิดไม่ทนไฟซึ่งใช้กับงานก่อสร้าง ",
                "description_en" => "Manufacture of structural non-refractory clay and ceramic products"
              ],
              [
                "category_id" => "42",
                "sub_category_code" => "2694",
                "description_th" => "การผลิตปูนซีเมนต์ ปูนไลม์และปูนปลาสเตอร์ ",
                "description_en" => "Manufacture of cement, lime and plaster"
              ],
              [
                "category_id" => "42",
                "sub_category_code" => "2695",
                "description_th" => "การผลิตผลิตภัณฑ์จากคอนกรีต ปูนซีเมนต์และปูนปลาสเตอร์ ",
                "description_en" => "Manufacture of articles of concrete, cement and plaster"
              ],
              [
                "category_id" => "42",
                "sub_category_code" => "2696",
                "description_th" => "การตัด การขึ้นรูปและการแต่งสำเร็จหิน ",
                "description_en" => "Cutting, shaping and finishing of stone"
              ],
              [
                "category_id" => "42",
                "sub_category_code" => "2699",
                "description_th" => "การผลิตผลิตภัณฑ์แร่อโลหะอื่น ๆ ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacture of other non-metallic mineral products n.e.c."
              ],
              [
                "category_id" => "45",
                "sub_category_code" => "2731",
                "description_th" => "การหล่อเหล็กและเหล็กกล้า ",
                "description_en" => "Casing of iron and steel"
              ],
              [
                "category_id" => "45",
                "sub_category_code" => "2732",
                "description_th" => "การหล่อโลหะที่มิใช่เหล็ก ",
                "description_en" => "Casing of non-ferrous metals"
              ],
              [
                "category_id" => "46",
                "sub_category_code" => "2811",
                "description_th" => "การผลิตผลิตภัณฑ์ที่มีโครงสร้างเป็นโลหะ ",
                "description_en" => "Manufacture of structural metal products"
              ],
              [
                "category_id" => "46",
                "sub_category_code" => "2812",
                "description_th" => "การผลิตที่เก็บน้ำและภาชนะบรรจุขนาดใหญ่ที่ทำจากโลหะ ",
                "description_en" => "Manufacture of tanks, reservoirs and containers of metal"
              ],
              [
                "category_id" => "46",
                "sub_category_code" => "2813",
                "description_th" => "การผลิตเครื่องกำเนิดพลังงานไอน้ำ ยกเว้นหม้อไอน้ำ (boiler) ที่ทำความร้อนจากส่วนกลาง ",
                "description_en" => "Manufacture of steam generators, except central heating hot water boilers"
              ],
              [
                "category_id" => "47",
                "sub_category_code" => "2891",
                "description_th" => "การผลิตผลิตภัณฑ์โลหะโดยวิธีการตี การอัด การตอกพิมพ์ การรีดและการผสมโลหะผง ",
                "description_en" => "Forging, pressing, stamping and roll-forming of metal; powder metallurgy"
              ],
              [
                "category_id" => "47",
                "sub_category_code" => "2892",
                "description_th" => "การบริการตกแต่ง เคลือบโลหะและบริการที่เกี่ยวเนื่องกัน ",
                "description_en" => "Treatment and coating of metals; general mechanical engineering on a fee or contract basis"
              ],
              [
                "category_id" => "47",
                "sub_category_code" => "2893",
                "description_th" => "การผลิตเครื่องตัด เครื่องมือที่ใช้งานด้วยมือและเครื่องโลหะ ทั่วไป ",
                "description_en" => "Manufacture of cutlery, hand tools and general hardware"
              ],
              [
                "category_id" => "47",
                "sub_category_code" => "2899",
                "description_th" => "การผลิตผลิตภัณฑ์โลหะประดิษฐ์ ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacture of other fabricated metal products n.e.c."
              ],
              [
                "category_id" => "48",
                "sub_category_code" => "2911",
                "description_th" => "การผลิตเครื่องยนต์และเครื่องกังหัน ยกเว้นเครื่องยนต์ที่ใช้ กับอากาศยาน ยานยนต์และจักรยานยนต์ ",
                "description_en" => "Manufacture of engies and turbines, except aircraft, vehicle and cycle engines"
              ],
              [
                "category_id" => "48",
                "sub_category_code" => "2912",
                "description_th" => "การผลิตเครื่องสูบ เครื่องอัด ก๊อก และวาล์ว ",
                "description_en" => "Manufacture of pumps, compressors, taps and valves"
              ],
              [
                "category_id" => "48",
                "sub_category_code" => "2913",
                "description_th" => "การผลิตตลับลูกปืน เกียร์ และอุปกรณ์ที่ใช้ขับเคลื่อน ",
                "description_en" => "Manufacture of bearings, gears, gearing and driving elements"
              ],
              [
                "category_id" => "48",
                "sub_category_code" => "2914",
                "description_th" => "การผลิตเตาอบและเตาเผา",
                "description_en" => "Manufacture of ovens, furnaces and furnace burners"
              ],
              [
                "category_id" => "48",
                "sub_category_code" => "2915",
                "description_th" => "การผลิตอุปกรณ์ที่ใช้ในการยกและขนย้าย ",
                "description_en" => "Manufacture of lifting and handling equipment"
              ],
              [
                "category_id" => "48",
                "sub_category_code" => "2919",
                "description_th" => "การผลิตเครื่องจักรที่ใช้งานทั่วไปอื่น ๆ ",
                "description_en" => "Manufacture of other general purpose machinery"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2921",
                "description_th" => "การผลิตเครื่องจักรที่ใช้ในการเกษตรและการป่าไม้ ",
                "description_en" => "Manufacture of agricultural and forestry machinery"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2922",
                "description_th" => "การผลิตเครื่องมือกล ",
                "description_en" => "Manufacture of machine-tools"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2923",
                "description_th" => "การผลิตเครื่องจักรสำหรับงานโลหะกรรม ",
                "description_en" => "Manufacture of machinery for metallurgy"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2924",
                "description_th" => "การผลิตเครื่องจักรที่ใช้ในการทำเหมืองแร่ เหมืองหินและ การก่อสร้าง ",
                "description_en" => "Manufacture of machinery for mining, quarrying and construction"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2925",
                "description_th" => "การผลิตเครื่องจักรที่ใช้ในกระบวนการผลิตอาหาร เครื่องดื่ม และยาสูบ ",
                "description_en" => "Manufacture of machinery for food, beverage and tobacco processing"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2926",
                "description_th" => "การผลิตเครื่องจักรที่ใช้ในการผลิตสิ่งทอ เครื่องแต่งกายและ เครื่องหนัง ",
                "description_en" => "Manufacture of machinery for textile, apparel and leather production"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2927",
                "description_th" => "การผลิตอาวุธและกระสุน ",
                "description_en" => "Manufacture of weapons and ammunition"
              ],
              [
                "category_id" => "49",
                "sub_category_code" => "2929",
                "description_th" => "การผลิตเครื่องจักรเพื่อใช้ในงานเฉพาะอย่างอื่น ๆ",
                "description_en" => "Manufacture of other special purpose machinery"
              ],
              [
                "category_id" => "60",
                "sub_category_code" => "3311",
                "description_th" => "การผลิตเครื่องมือทางการแพทย์ ศัลยกรรมและเครื่องใช้ทาง ศัลยศาสตร์กระดูก ",
                "description_en" => "Manufacture of medical and surgical equipment and orthopaedic appliances"
              ],
              [
                "category_id" => "60",
                "sub_category_code" => "3312",
                "description_th" => "การผลิตอุปกรณ์และเครื่องมือที่ใช้ในการเดินเรือ การเดิน อากาศ การวัด ตรวจสอบ ทดสอบและวัตถุประสงค์อื่น ๆ ยกเว้นอุปกรณ์ควบคุมกระบวนการผลิตในทางอุตสาหกรรม ",
                "description_en" => "Manufacture of instruments and appliances for measuring, checking, testing, navigating and others purposes, except industrial process control equipment"
              ],
              [
                "category_id" => "60",
                "sub_category_code" => "3313",
                "description_th" => "การผลิตอุปกรณ์ควบคุมกระบวนการผลิตในทางอุตสาหกรรม ",
                "description_en" => "Manufacture of industrial process control equipment"
              ],
              [
                "category_id" => "66",
                "sub_category_code" => "3511",
                "description_th" => "การต่อเรือและการซ่อมเรือ ",
                "description_en" => "Building and repairing of ships"
              ],
              [
                "category_id" => "66",
                "sub_category_code" => "3512",
                "description_th" => "การต่อเรือและการซ่อมเรือที่ใช้เพื่อความสำราญและการกีฬา ",
                "description_en" => "Building and repairing of pleasure and sporting boats"
              ],
              [
                "category_id" => "69",
                "sub_category_code" => "3591",
                "description_th" => "การผลิตจักรยานยนต์ ",
                "description_en" => "Manufacture of motorcycles"
              ],
              [
                "category_id" => "69",
                "sub_category_code" => "3592",
                "description_th" => "การผลิตจักรยานสองล้อและรถสำหรับคนพิการ ",
                "description_en" => "Manufacture of bicycles and invalid carriages"
              ],
              [
                "category_id" => "69",
                "sub_category_code" => "3599",
                "description_th" => "การผลิตอุปกรณ์การขนส่งอื่นๆ ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Manufacture of other transport equipment n.e.c."
              ],
              [
                "category_id" => "71",
                "sub_category_code" => "3691",
                "description_th" => "การผลิตเครื่องประดับเพชรพลอย และผลิตภัณฑ์ที่เกี่ยวข้อง",
                "description_en" => "Manufacture of jewellery and related articles"
              ],
              [
                "category_id" => "71",
                "sub_category_code" => "3692",
                "description_th" => "การผลิตเครื่องดนตรี ",
                "description_en" => "Manufacture of musical instruments"
              ],
              [
                "category_id" => "71",
                "sub_category_code" => "3693",
                "description_th" => "การผลิตเครื่องกีฬา ",
                "description_en" => "Manufacture of sports goods"
              ],
              [
                "category_id" => "71",
                "sub_category_code" => "3694",
                "description_th" => "การผลิตเกมและของเล่น ",
                "description_en" => "Manufacture of games and toys"
              ],
              [
                "category_id" => "71",
                "sub_category_code" => "3699",
                "description_th" => "การผลิตผลิตภัณฑ์อื่นๆ ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Other manufacturing n.e.c."
              ],
              [
                "category_id" => "88",
                "sub_category_code" => "5121",
                "description_th" => "การขายส่งวัตถุดิบทางการเกษตร และสัตว์ที่มีชีวิต ",
                "description_en" => "Wholesale of agricultural raw materials and live animals"
              ],
              [
                "category_id" => "88",
                "sub_category_code" => "5122",
                "description_th" => "การขายส่งอาหารประเภทต่าง ๆ ",
                "description_en" => "Wholesale of food, beverages and tobacco"
              ],
              [
                "category_id" => "88",
                "sub_category_code" => "5123",
                "description_th" => "การขายส่งเครื่องดื่มและยาสูบ ",
                "description_en" => "Wholesale of beverages and tobacco"
              ],
              [
                "category_id" => "89",
                "sub_category_code" => "5131",
                "description_th" => "การขายส่งสินค้าสิ่งทอสิ่งถัก เสื้อผ้าและรองเท้า ",
                "description_en" => "Wholesale of textiles, clothing and footware"
              ],
              [
                "category_id" => "89",
                "sub_category_code" => "5139",
                "description_th" => "การขายส่งสินค้าที่ใช้ในครัวเรือนอื่น ๆ ",
                "description_en" => "Wholesale of other household goods"
              ],
              [
                "category_id" => "90",
                "sub_category_code" => "5141",
                "description_th" => "การขายส่งเชื้อเพลิงแข็ง เชื้อเพลิงเหลว แก๊ส และผลิตภัณฑ์ ที่เกี่ยวข้อง ",
                "description_en" => "Wholesale of solid, liquid and gaseous fuels and related products"
              ],
              [
                "category_id" => "90",
                "sub_category_code" => "5142",
                "description_th" => "การขายส่งโลหะ และแร่โลหะ ",
                "description_en" => "Wholesale of metals and metal ores"
              ],
              [
                "category_id" => "90",
                "sub_category_code" => "5143",
                "description_th" => "การขายส่งวัสดุก่อสร้าง เครื่องโลหะ อุปกรณ์เกี่ยวกับการวางท่อ และการทำความร้อน และเครื่องมือเครื่องใช้ ",
                "description_en" => "Wholesale of construction materials, hardware, plumbing and heating equipment and supplies"
              ],
              [
                "category_id" => "90",
                "sub_category_code" => "5149",
                "description_th" => "การขายส่งสินค้าขั้นกลางอื่น ๆ และของที่ไม่ใช้แล้ว ",
                "description_en" => "Wholesale of other intermediate products, waste and scrap"
              ],
              [
                "category_id" => "93",
                "sub_category_code" => "5211",
                "description_th" => "การขายปลีกอาหาร เครื่องดื่ม หรือยาสูบในร้านค้าที่ไม่ระบุ ประเภทสินค้า ",
                "description_en" => "Retail sale in non-specialized stores with food, beverages of tobacco predominating"
              ],
              [
                "category_id" => "93",
                "sub_category_code" => "5219",
                "description_th" => "การขายปลีกสินค้าทั่วไปอื่น ๆ หรือห้างสรรพสินค้า ",
                "description_en" => "Other retail sale in non-specialized stores"
              ],
              [
                "category_id" => "95",
                "sub_category_code" => "5231",
                "description_th" => "การขายปลีกสินค้าทางเภสัชกรรมและเวชภัณฑ์ เครื่องสำอาง และเครื่องหอม ",
                "description_en" => "Retail sale of pharmaceutical and medical goods, cosmetic and toilet articles"
              ],
              [
                "category_id" => "95",
                "sub_category_code" => "5232",
                "description_th" => "การขายปลีกสินค้าสิ่งทอสิ่งถัก เสื้อผ้า รองเท้า และเครื่องหนัง ",
                "description_en" => "Retail sale of textiles, clothing, footwear and leather goods"
              ],
              [
                "category_id" => "95",
                "sub_category_code" => "5233",
                "description_th" => "การขายปลีกเครื่องมือ สิ่งของ และเครื่องใช้ในครัวเรือน ",
                "description_en" => "Retail sale of household appliances, articles and equipment"
              ],
              [
                "category_id" => "95",
                "sub_category_code" => "5234",
                "description_th" => "การขายปลีกเครื่องโลหะ สี และกระจก ",
                "description_en" => "Retail sale of hardware, paints and glass"
              ],
              [
                "category_id" => "95",
                "sub_category_code" => "5239",
                "description_th" => "การขายปลีกสินค้าอื่น ๆ ในร้านค้าเฉพาะอย่าง ",
                "description_en" => "Other retail sale in specialized stores"
              ],
              [
                "category_id" => "97",
                "sub_category_code" => "5251",
                "description_th" => "การขายปลีกโดยการสั่งซื้อทางไปรษณีย์ ",
                "description_en" => "Retail sale via mail order houses"
              ],
              [
                "category_id" => "97",
                "sub_category_code" => "5252",
                "description_th" => "การขายปลีกตามแผงลอยและตลาดสด ",
                "description_en" => "Retail sale via stalls and markets"
              ],
              [
                "category_id" => "97",
                "sub_category_code" => "5259",
                "description_th" => "การขายปลีกสินค้านอกร้านค้าอื่น ๆ ",
                "description_en" => "Other non-store retail sale"
              ],
              [
                "category_id" => "102",
                "sub_category_code" => "6021",
                "description_th" => "การขนส่งผู้โดยสารทางบกอื่น ๆ ที่มีตารางเวลา ",
                "description_en" => "Other scheduled passenger land transport"
              ],
              [
                "category_id" => "102",
                "sub_category_code" => "6022",
                "description_th" => "การขนส่งผู้โดยสารทางบกอื่น ๆ ที่ไม่มีตารางเวลา ",
                "description_en" => "Other non-scheduled passenger land transport"
              ],
              [
                "category_id" => "102",
                "sub_category_code" => "6023",
                "description_th" => "การขนส่งสินค้าทางถนน ",
                "description_en" => "Freight transport by road"
              ],
              [
                "category_id" => "108",
                "sub_category_code" => "6301",
                "description_th" => "การขนถ่ายสินค้า",
                "description_en" => "Cargo handling"
              ],
              [
                "category_id" => "108",
                "sub_category_code" => "6302",
                "description_th" => "สถานที่เก็บสินค้าและการเก็บสินค้า ",
                "description_en" => "Storage and warehousing"
              ],
              [
                "category_id" => "108",
                "sub_category_code" => "6303",
                "description_th" => "การบริการเสริมด้านการขนส่ง",
                "description_en" => "Other supporting transport activities"
              ],
              [
                "category_id" => "108",
                "sub_category_code" => "6304",
                "description_th" => "ตัวแทนธุรกิจการท่องเที่ยวและผู้จัดนำเที่ยว รวมทั้งการบริการ นักท่องเที่ยว ซึ่งมิได้จัดประเภทไว้ในที่อื่น ",
                "description_en" => "Activities of travel agencies and tour operators; tourist assistance activities n.e.c."
              ],
              [
                "category_id" => "108",
                "sub_category_code" => "6309",
                "description_th" => "บริการเกี่ยวเนื่องกับการขนส่งอื่น ๆ ",
                "description_en" => "Activities of other transport agencies"
              ],
              [
                "category_id" => "109",
                "sub_category_code" => "6411",
                "description_th" => "บริการทางไปรษณีย์ของรัฐ ",
                "description_en" => "National post activities"
              ],
              [
                "category_id" => "109",
                "sub_category_code" => "6412",
                "description_th" => "บริการทางไปรษณีย์ภัณฑ์และพัสดุภัณฑ์โดยภาคเอกชน ",
                "description_en" => "Courier activities other than national post activities"
              ],
              [
                "category_id" => "111",
                "sub_category_code" => "6511",
                "description_th" => "ธนาคารกลาง  ",
                "description_en" => "Central banking "
              ],
              [
                "category_id" => "111",
                "sub_category_code" => "6519",
                "description_th" => "การเป็นตัวกลางทางเงินตราอื่น ๆ",
                "description_en" => "Other financial institutions"
              ],
              [
                "category_id" => "112",
                "sub_category_code" => "6591",
                "description_th" => "การเช่าซื้อ",
                "description_en" => "Financial leasing"
              ],
              [
                "category_id" => "112",
                "sub_category_code" => "6592",
                "description_th" => "การให้สินเชื่ออื่น ๆ ",
                "description_en" => "Other credit granting"
              ],
              [
                "category_id" => "112",
                "sub_category_code" => "6599",
                "description_th" => "ตัวกลางทางการเงินอื่น ๆ ที่มิได้ระบุไว้ที่อื่น ",
                "description_en" => "Other financial intermediation n.e.c."
              ],
              [
                "category_id" => "113",
                "sub_category_code" => "6601",
                "description_th" => "การประกันชีวิต ",
                "description_en" => "Life insurance"
              ],
              [
                "category_id" => "113",
                "sub_category_code" => "6602",
                "description_th" => "กองทุนเลี้ยงชีพ",
                "description_en" => "Pension funding"
              ],
              [
                "category_id" => "113",
                "sub_category_code" => "6603",
                "description_th" => "การประกันอื่น ๆ ที่มิใช้การประกันชีวิต",
                "description_en" => "Non-life insurance"
              ],
              [
                "category_id" => "114",
                "sub_category_code" => "6711",
                "description_th" => "การบริหารตลาดการเงิน ",
                "description_en" => "Administration of financial markets"
              ],
              [
                "category_id" => "114",
                "sub_category_code" => "6712",
                "description_th" => "การซื้อขายหลักทรัพย์ ",
                "description_en" => "Security dealing activities"
              ],
              [
                "category_id" => "114",
                "sub_category_code" => "6719",
                "description_th" => "กิจกรรมตัวกลางสนุบสนุนทางการเงินที่มิได้ระบุไว้ที่อื่น",
                "description_en" => "Activities auxiliary to financial intermediation n.e.c."
              ],
              [
                "category_id" => "118",
                "sub_category_code" => "7111",
                "description_th" => "การให้เช่าอุปกรณ์ขนส่งทางบก ",
                "description_en" => "Renting of land transport equipment"
              ],
              [
                "category_id" => "118",
                "sub_category_code" => "7112",
                "description_th" => "การให้เช่าอุปกรณ์ขนส่งทางน้ำ ",
                "description_en" => "Renting of water transport equipment"
              ],
              [
                "category_id" => "118",
                "sub_category_code" => "7113",
                "description_th" => "การให้เช่าอุปกรณ์ขนส่งทางอากาศ ",
                "description_en" => "Renting of air transport equipment"
              ],
              [
                "category_id" => "119",
                "sub_category_code" => "7121",
                "description_th" => "การให้เช่าเครื่องจักรและอุปกรณ์ทางการเกษตร ",
                "description_en" => "Renting of agricultural machinery and equipment"
              ],
              [
                "category_id" => "119",
                "sub_category_code" => "7122",
                "description_th" => "การให้เช่าเครื่องจักรและอุปกรณ์ทางการก่อสร้าง และวิศวกรรมโยธา ",
                "description_en" => "Renting of construction and vivil engineering machinery and equipment"
              ],
              [
                "category_id" => "119",
                "sub_category_code" => "7123",
                "description_th" => "การให้เช่าเครื่องจักรและอุปกรณ์สำนักงาน รวมทั้งคอมพิวเตอร์",
                "description_en" => "Renting of office machinery and equipment (including computers)"
              ],
              [
                "category_id" => "119",
                "sub_category_code" => "7129",
                "description_th" => "การให้เช่าเครื่องจักรและอุปกรณ์อื่น ๆ ซึ่งมิได้ระบุไว้ที่อื่น ",
                "description_en" => "Renting of other machinery and equipment n.e.c."
              ],
              [
                "category_id" => "129",
                "sub_category_code" => "7411",
                "description_th" => "การให้บริการทางกฎหมาย ",
                "description_en" => "Legal activities"
              ],
              [
                "category_id" => "129",
                "sub_category_code" => "7412",
                "description_th" => "การทำบัญชี การตรวจสอบบัญชี การให้คำปรึกษาเกี่ยวกับภาษีอากร",
                "description_en" => "Accounting, book-keeping and audition activities; tax consultancy"
              ],
              [
                "category_id" => "129",
                "sub_category_code" => "7413",
                "description_th" => "การวิจัยทางการตลาด และการสำรวจประชามติ",
                "description_en" => "Market research and public opinion polling"
              ],
              [
                "category_id" => "129",
                "sub_category_code" => "7414",
                "description_th" => "การบริการการให้คำปรึกษาทางธุรกิจและการจัดการ ",
                "description_en" => "Business and management consultancy activities"
              ],
              [
                "category_id" => "130",
                "sub_category_code" => "7421",
                "description_th" => "การบริการให้คำปรึกษาทางสถาปัตยกรรม วิศวกรรม และกิจกรรมทางเทคนิคอื่น ๆ ที่เกี่ยวข้อง ",
                "description_en" => "Architectural and engineering activities and related technical consultancy"
              ],
              [
                "category_id" => "130",
                "sub_category_code" => "7422",
                "description_th" => "การบริการการตรวจสอบและการวิเคราะห์ทางเทคนิค ",
                "description_en" => "Technical testing and analysis"
              ],
              [
                "category_id" => "132",
                "sub_category_code" => "7491",
                "description_th" => "การจัดหาคนงานและบริหารงานบุคคล",
                "description_en" => "Labour recruitment and provision of personnel"
              ],
              [
                "category_id" => "132",
                "sub_category_code" => "7492",
                "description_th" => "การสืบสวนและการรักษาความปลอดภัย",
                "description_en" => "Investigation and security activities"
              ],
              [
                "category_id" => "132",
                "sub_category_code" => "7493",
                "description_th" => "การบริการทำความสะอาดอาคาร ",
                "description_en" => "Building-cleaning activities"
              ],
              [
                "category_id" => "132",
                "sub_category_code" => "7494",
                "description_th" => "การบริการการถ่ายรูป",
                "description_en" => "Photographic activities"
              ],
              [
                "category_id" => "132",
                "sub_category_code" => "7495",
                "description_th" => "การบริการบรรจุหีบห่อ",
                "description_en" => "Packaging activities"
              ],
              [
                "category_id" => "132",
                "sub_category_code" => "7499",
                "description_th" => "การบริการทางธุรกิจอื่น ๆ ที่ไม่ได้ระบุไว้ที่อื่น",
                "description_en" => "Other business activities n.e.c."
              ],
              [
                "category_id" => "133",
                "sub_category_code" => "7511",
                "description_th" => "การให้บริการสาธารณะทั่วไป",
                "description_en" => "General (overall) public service activities"
              ],
              [
                "category_id" => "133",
                "sub_category_code" => "7512",
                "description_th" => "การบริการชุมชนด้านสุขภาพ การบริการการศึกษา วัฒนธรรม และการบริการทางสังคมอื่น ๆ ยกเว้นการประกันสังคม",
                "description_en" => "Regulation of the activities of agencies tha provide health care, education, cultural services and other social services, excluding social security"
              ],
              [
                "category_id" => "133",
                "sub_category_code" => "7513",
                "description_th" => "การส่งเสริมประสิทธิภาพของธุรกิจ",
                "description_en" => "Regulation of and contribution to more efficient operation business"
              ],
              [
                "category_id" => "133",
                "sub_category_code" => "7514",
                "description_th" => "กิจกรรมส่งเสริมทางรัฐ",
                "description_en" => "Ancillary service activities for the Government as a whole"
              ],
              [
                "category_id" => "134",
                "sub_category_code" => "7521",
                "description_th" => "การต่างประเทศ ",
                "description_en" => "Foreign affairs"
              ],
              [
                "category_id" => "134",
                "sub_category_code" => "7522",
                "description_th" => "การป้องกันประเทศ ",
                "description_en" => "Defence activities"
              ],
              [
                "category_id" => "134",
                "sub_category_code" => "7523",
                "description_th" => "การรักษาระเบียบและความปลอดภัยทางสังคม",
                "description_en" => "Public order and safety activities"
              ],
              [
                "category_id" => "137",
                "sub_category_code" => "8021",
                "description_th" => "การศึกษาระดับมัธยมทั่วไป",
                "description_en" => "General secondary education"
              ],
              [
                "category_id" => "137",
                "sub_category_code" => "8022",
                "description_th" => "การศึกษาระดับอาชีวะ",
                "description_en" => "Technical and vocational secondary education"
              ],
              [
                "category_id" => "140",
                "sub_category_code" => "8511",
                "description_th" => "การให้การรักษาพยาบาล",
                "description_en" => "Hospital activities"
              ],
              [
                "category_id" => "140",
                "sub_category_code" => "8512",
                "description_th" => "การตรวจรักษาโรค และทันตกรรม",
                "description_en" => "Medical and dental practice activities"
              ],
              [
                "category_id" => "140",
                "sub_category_code" => "8519",
                "description_th" => "การบริการเกี่ยวกับสุขภาพอื่น ๆ",
                "description_en" => "Other human health activities"
              ],
              [
                "category_id" => "142",
                "sub_category_code" => "8531",
                "description_th" => "การสังคมสงเคราะห์ด้วยการให้ที่พัก",
                "description_en" => "Social work with accommodation"
              ],
              [
                "category_id" => "142",
                "sub_category_code" => "8532",
                "description_th" => "การสังคมสงเคราะห์ที่ไม่ให้ที่พัก",
                "description_en" => "Social work without accommodation"
              ],
              [
                "category_id" => "143",
                "sub_category_code" => "9111",
                "description_th" => "กิจกรรมขององค์กรทางธุรกิจ และองค์กรนายจ้าง",
                "description_en" => "Activities of business and employers' organizations"
              ],
              [
                "category_id" => "143",
                "sub_category_code" => "9112",
                "description_th" => "กิจกรรมองค์กรทางวิชาชีพ",
                "description_en" => "Activities of professional organizations"
              ],
              [
                "category_id" => "145",
                "sub_category_code" => "9191",
                "description_th" => "กิจกรรมองค์กรทางศาสนา",
                "description_en" => "Activities of religious organizations"
              ],
              [
                "category_id" => "145",
                "sub_category_code" => "9192",
                "description_th" => "กิจกรรมองค์กรทางการเมือง ",
                "description_en" => "Activities of political organizations"
              ],
              [
                "category_id" => "145",
                "sub_category_code" => "9199",
                "description_th" => "กิจกรรมองค์กรสมาชิกอื่น ๆ ที่มิได้ระบุไว้ที่อื่น",
                "description_en" => "Activities of other membership organizations n.e.c."
              ],
              [
                "category_id" => "146",
                "sub_category_code" => "9211",
                "description_th" => "การผลิตและจำหน่ายภาพยนตร์และวีดิโอ",
                "description_en" => "Motion picture and video production and distribution"
              ],
              [
                "category_id" => "146",
                "sub_category_code" => "9212",
                "description_th" => "การฉายภาพยนตร์ ",
                "description_en" => "Motion picture projection"
              ],
              [
                "category_id" => "146",
                "sub_category_code" => "9213",
                "description_th" => "การกระจายเสียงทางวิทยุ และแพร่ภาพทางโทรทัศน์",
                "description_en" => "Radio and television activities"
              ],
              [
                "category_id" => "146",
                "sub_category_code" => "9214",
                "description_th" => "ศิลปการละคร การดนตรี และอื่น ๆ",
                "description_en" => "Dramatic arts, music and other arts activities"
              ],
              [
                "category_id" => "146",
                "sub_category_code" => "9219",
                "description_th" => "กิจกรรมบันเทิงอื่น ๆ ที่มิได้ระบุไว้ที่อื่น",
                "description_en" => "Other entertainment activities n.e.c."
              ],
              [
                "category_id" => "148",
                "sub_category_code" => "9231",
                "description_th" => "งานห้องสมุดและสถานที่เก็บเอกสารสำคัญ",
                "description_en" => "Library and archives activities"
              ],
              [
                "category_id" => "148",
                "sub_category_code" => "9232",
                "description_th" => "งานพิพิธภัณฑ์และอนุรักษ์สถานที่ทางประวัติศาสตร์",
                "description_en" => "Museums activities and preservation of historical sites and building"
              ],
              [
                "category_id" => "148",
                "sub_category_code" => "9233",
                "description_th" => "งานสวนพฤกษศาสตร์ สวนสัตว์ และวนอุทยาน",
                "description_en" => "Botanical and zoological gargens and nature reserves activities"
              ],
              [
                "category_id" => "149",
                "sub_category_code" => "9241",
                "description_th" => "การกีฬา ",
                "description_en" => "Sporting activities"
              ],
              [
                "category_id" => "149",
                "sub_category_code" => "9249",
                "description_th" => "กิจกรรมนันทนาการอื่น ๆ ",
                "description_en" => "Other recreational activities"
              ],
              [
                "category_id" => "150",
                "sub_category_code" => "9301",
                "description_th" => "บริการซักรีด ซักแห้งเสื้อผ้า และเสื้อขนสัตว์",
                "description_en" => "Washing and (dry-) cleaning of textile and fur products"
              ],
              [
                "category_id" => "150",
                "sub_category_code" => "9302",
                "description_th" => "บริการร้านทำผม และเสริมสวย",
                "description_en" => "Hairdressing and other beauty treatment"
              ],
              [
                "category_id" => "150",
                "sub_category_code" => "9303",
                "description_th" => "บริการการทำศพ และกิจกรรมที่เกี่ยวข้อง",
                "description_en" => "Funeral and related activities"
              ],
              [
                "category_id" => "150",
                "sub_category_code" => "9309",
                "description_th" => "กิจกรรมบริการอื่น ๆ ที่มิได้ระบุไว้ที่อื่น",
                "description_en" => "Other service activities n.e.c."]
        ]);

    }
}
