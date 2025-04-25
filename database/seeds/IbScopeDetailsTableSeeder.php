<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IbScopeDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ib_scope_details')->insert([
            [
                'ib_scope_topic_id' => 1,
                'name' => 'ผลิตภัณฑ์เหล็ก',
                'name_en' => 'Steel products'    
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'วัสดุก่อสร้าง คอนกรีต สุขภัณฑ์ เซรามิก เครื่องเรือน',
                'name_en' => 'Building materials Concrete Sanitary ware Ceramics Furniture'    
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'บริภัณฑ์ส่องสว่าง',
                'name_en' => 'Lighting fixtures'    
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'ไฟฟ้ากำลัง',
                'name_en' => 'Power electricity'  
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'เครื่องใช้ไฟฟ้า',
                'name_en' => 'Electrical appliances'    
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'เครื่องใช้อิเล็กทรอนิกส์',
                'name_en' => 'Electronic devices'    
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'โภคภัณฑ์ ของเล่น',
                'name_en' => 'Consumer goods:Toys'    
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'ยาง เคมี สิ่งทอ ปิโตรเลียม อาหาร',
                'name_en' => 'Rubber Chemicals Textiles Petroleum Food'    
            ],
            [
                'ib_scope_topic_id' => 1,
                'name' => 'ยานยนต์และชิ้นส่วนยานยนต์ เครื่องกล',
                'name_en' => 'Automobiles and automotive parts,Mechanical engineering'    
            ],
            [
                'ib_scope_topic_id' => 2,
                'name' => 'ลักษณะทั่วไป',
                'name_en' => 'General characteristics'    
            ],
            [
                'ib_scope_topic_id' => 2,
                'name' => 'รูปแบบและขนาด',
                'name_en' => 'Shape and size'    
            ],
            [
                'ib_scope_topic_id' => 2,
                'name' => 'ปริมาณและการบรรจุ (เฉพาะการตรวจก่อนการส่งมอบ)',
                'name_en' => 'Quantity and packaging (for inspection prior to delivery)'    
            ],
            [
                'ib_scope_topic_id' => 3,
                'name' => 'ลักษณะทั่วไป,รูปแบบ สี และขนาด,ตรวจโลหะ,ปริมาณและการบรรจุ (เฉพาะก่อนการส่งมอบ)',
                'name_en' => 'General characteristics,Shape,Color and size,Metal inspection,Quantity and packaging (for inspection prior to delivery)'    
            ],
            [
                'ib_scope_topic_id' => 4,
                'name' => 'สําหรับกลุ่มผลิตภัณฑ์อาหารแช่แข็ง,กลุ่มผลิตภัณฑ์อาหารกระป๋อง',
                'name_en' => 'For frozen food products,Canned food products'    
            ],
            [
                'ib_scope_topic_id' => 5,
                'name' => 'จํานวน',
                'name_en' => 'Quantity'    
            ],
            [
                'ib_scope_topic_id' => 5,
                'name' => 'สภาพความสมบูรณ์ภายนอกของรถยนต์ เช่น สภาพของกระจก สภาพทั่วไปของตัวถัง สภาพยางและล้อ ความสะอาด และอื่น ๆ ที่อยู่ภายนอก',
                'name_en' => ''    
            ],
            [
                'ib_scope_topic_id' => 6,
                'name' => 'การตรวจชิ้นส่วนประกอบการผลิตถัง',
                'name_en' => 'External condition of the vehicle such as the condition of the glass general condition of the body condition of tires and wheels cleanliness and other external features'    
            ],
            [
                'ib_scope_topic_id' => 6,
                'name' => 'การตรวจระหว่างการประกอบ',
                'name_en' => 'Inspection during assembly'    
            ],
            [
                'ib_scope_topic_id' => 6,
                'name' => 'การทํากระบวนการทางความร้อน',
                'name_en' => 'Heat treatment process'    
            ],
            [
                'ib_scope_topic_id' => 6,
                'name' => 'การทดสอบทั้งทางกล การรั่ว การขยายตัวและการระเบิด และการตรวจสอบปริมาตร',
                'name_en' => 'Testing for mechanical leakage expansion and explosion as well as volume inspection'    
            ],
            [
                'ib_scope_topic_id' => 6,
                'name' => 'การตรวจสอบก่อนการส่งมอบ',
                'name_en' => 'Pre-delivery inspection'    
            ],
            [
                'ib_scope_topic_id' => 7,
                'name' => 'ปริมาณ,คุณภาพทางกายภาพและลักษณะทั่วไป ดังต่อไปนี้,ประเภท ชนิด,ความบริสุทธิ์,ความชื้น,ขนาดของเมล็ดข้าว,ส่วนผสม (ข้าวเต็มเมล็ด ข้าวหัก ต้นข้าว),ข้าวและสิ่งที่อาจมีปนได้ (เมล็ดเสีย เมล็ดเหลือง เมล็ดท้องไข่ เมล็ดแดง ฯลฯ),ไม่มีแมลงที่ยังมีชีวิต,ระดับการขัดสี,ไม่ครอบคลุมการตรวจความบริสุทธิ์ด้วยวิธีวิเคราะห์ในห้องปฏิบัติการในรายการปริมาณอมิโลส (Amylose content) และค่าการสลายเมล็ดข้าวในด่าง (Alkali spreading value)',
                'name_en' => 'Quantity,Physical quality and general characteristics as follows:,Type,Variety,Purity,Moisture content,Rice grain size,Composition (whole grains broken grains rice husk),Rice and possible contaminants (damaged grains yellow grains egg-shaped grains red grains etc.),No live insects,Milling degree,Does not include purity testing through laboratory analysis for amylose content and alkali spreading value'    
            ],
            [
                'ib_scope_topic_id' => 8,
                'name' => 'ปริมาณ,คุณภาพทางกายภาพและลักษณะทั่วไป,ประเภท ชนิด,พื้นข้าว (ยกเว้นข้าวเหนียวขาว),ความชื้น,ขนาดของเมล็ดข้าว,ส่วนผสม (ข้าวเต็มเมล็ด ข้าวหัก ต้นข้าว),ข้าวและสิ่งที่อาจมีปนได้ (เมล็ดเสีย เมล็ดเหลือง เมล็ดท้องไข่ เมล็ดแดง ฯลฯ),ไม่มีแมลงที่ยังมีชีวิต,ระดับการขัดสี (ยกเว้นข้าวกล้อง)',
                'name_en' => 'Quantity,Physical quality and general characteristics,Type,Variety,Rice floor (except for white sticky rice),Moisture content,Rice grain size,Composition (whole grains broken grains rice husk),Rice and possible contaminants (damaged grains yellow grains egg-shaped grains red grains etc.),No live insects,Milling degree (except for brown rice)'    
            ],

        ]);
    }
}
