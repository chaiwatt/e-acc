<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IbScopeTopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ib_scope_topics')->insert([
            [
                'ib_sub_category_scope_id' => 1,
                'name' => 'การตรวจกระบวนการผลิต ระบบการควบคุมคุณภาพและการตรวจประเมินผลิตภัณฑ์ สำหรับผลิตภัณฑ์',
                'name_en' => 'Production process inspection quality control system and product evaluation for products',
                'standard' => '- หลักเกณฑ์การตรวจสอบเพื่อการอนุญาตของสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม<br>- หลักเกณฑ์เฉพาะในการตรวจสอบเพื่อการอนุญาตผลิตภัณฑ์ที่เกี่ยวข้อง<br>- มาตรฐานผลิตภัณฑ์อุตสาหกรรมที่เกี่ยวข้อง<br>– เอกสารขั้นตอนการดําเนินงานของบริษัทหมายเลข .......... ( เช่น THLPP.01)<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป',
                'standard_en' => '- Guidelines for inspection for authorization by the Thai Industrial Standards Institute<br>- Specific guidelines for inspection for authorization of related products<br>- Related industrial product standards<br>– Company operational procedure document number .......... (e.g., THLPP.01)<br>*The document number structure varies for each company'              
            ],
            [
                'ib_sub_category_scope_id' => 2,
                'name' => 'การตรวจสายการผลิตและการตรวจก่อนการส่งมอบในรายการต่อไปนี้',
                'name_en' => 'Production line inspection and pre-delivery inspection in the following items',
                'standard' => '- วิธีปฏิบัติงานของบริษัทหมายเลข ................. (เช่น P-INSP-WI-SL-001)<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>- ข้อกำหนดของลูกค้า',
                'standard_en' => '- Company work procedure number ................. (e.g., P-INSP-WI-SL-001)<br>*Note that the document number structure varies by company)<br>- Customer requirements',
            ],
            [
                'ib_sub_category_scope_id' => 3,
                'name' => 'การตรวจสายการผลิต (In-line process inspection) และการตรวจก่อนการส่งมอบ (Pre-shipment inspection) ในรายการต่อไปนี้',
                'name_en' => 'In-line process inspection and pre-shipment inspection in the following items',
                'standard' => '- เอกสารวิธีการปฏิบัติงานของบริษัท หมายเลข WI-INSP-SL-004<br>- ข้อกำหนดของลูกค้า' ,
                'standard_en' => '- Company Work Instruction Document No. WI-INSP-SL-004<br>- Customer Requirements'
            ],
            [
                'ib_sub_category_scope_id' => 4,
                'name' => 'การตรวจระหว่างการผลิตและการตรวจก่อนการส่งมอบ',
                'name_en' => 'Inspection during production and pre-shipment inspection',
                'standard' => '- วิธีปฏิบัติงานของบริษัทหมายเลข  .................  (เช่น P-CORP-I-09)<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>- ข้อกําหนดของลูกค้า' ,
                'standard_en' => '- Company procedure number  .................  (e.g., P-CORP-I-09)<br>*Note that the document number structure varies by company)<br>- Customer requirements'    
            ],
            [
                'ib_sub_category_scope_id' => 5,
                'name' => 'การตรวจสภาพทั่วไปก่อนการส่งมอบในรายการต่อไปนี้',
                'name_en' => 'General condition inspection before delivery in the following items',
                'standard' => '– ขั้นตอนการดําเนินงานของบริษัท หมายเลข ........ (เช่น PR-TH-NR-OGC-IN-001 และ PR-TH-NR-OGC-IN-002)<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>– เอกสาร New Vehicle Receiving and Inspection Procedures Issued May 1, 1989 ของ Federal Chamber of Automotive Industries' ,
                'standard_en' => '– Company operational procedures number ........ (e.g., PR-TH-NR-OGC-IN-001 and PR-TH-NR-OGC-IN-002)<br>*where the document number structure varies by company)<br>– New Vehicle Receiving and Inspection Procedures document Issued May 1, 1989 by the Federal Chamber of Automotive Industries'    
            ],
            [
                'ib_sub_category_scope_id' => 6,
                'name' => 'การตรวจกระบวนการผลิตและการควบคุมคุณภาพ ในรายการต่อไปนี้',
                'name_en' => 'Production process inspection and quality control in the following items',
                'standard' => '– ขั้นตอนการดําเนินงานของบริษัท หมายเลข ........... (เช่น PR-TH-I&E-IN-071)<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>– ข้อกําหนดของลูกค้า' ,
                'standard_en' => '– Company Operation Procedure Number ........... (e.g., PR-TH-I&E-IN-071)<br>*Note that the document number structure may vary for each company)<br>– Customer Requirements'  
            ],
            [
                'ib_sub_category_scope_id' => 7,
                'name' => 'การตรวจในขั้นตรวจปล่อยในรายการต่อไปนี้',
                'name_en' => 'Inspection at the release stage in the following items',
                'standard' => '– ประกาศกระทรวงพาณิชย์ เรื่องหลักเกณฑ์และวิธีการการจัดให้มีการตรวจสอบมาตรฐานสินค้าและการตรวจสอบมาตรฐานสินค้าข้าวหอมมะลิไทย<br>– ขั้นตอนการดำเนินงานของบริษัท หมายเลข .............. (เช่น PR-TH-NR-AGR-IN-004 และ PR-TH-NR-AGR-IN-005)<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>– ข้อกำหนดของลูกค้า',
                'standard_en' => '– Announcement of the Ministry of Commerce regarding the criteria and methods for arranging the inspection of product standards and the inspection of Thai Hom Mali rice product standards<br>– Operational procedures of the company, document number .............. (e.g., PR-TH-NR-AGR-IN-004 and PR-TH-NR-AGR-IN-005)<br>*Note that the document number structure may vary for each company)<br>– Customer requirements'    
            ],

            [
                'ib_sub_category_scope_id' => 8,
                'name' => 'การตรวจในขั้นตรวจปล่อยในรายการต่อไปนี้',
                'name_en' => 'Inspection at the release stage in the following items',
                'standard' => '– ประกาศกระทรวงพาณิชย์ เรื่องหลักเกณฑ์และวิธีการการจัดให้มีการตรวจสอบมาตรฐานสินค้าและการตรวจสอบมาตรฐานสินค้าข้าวหอมมะลิไทย<br>– ขั้นตอนการดำเนินงานของบริษัท หมายเลข .............. (เช่น PR-TH-NR-AGR-IN-004 และ PR-TH-NR-AGR-IN-005)<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>– ข้อกำหนดของลูกค้า',
                'standard_en' => '– Announcement of the Ministry of Commerce regarding the criteria and methods for arranging the inspection of product standards and the inspection of Thai Hom Mali rice product standards<br>– Operational procedures of the company, document number .............. (e.g., PR-TH-NR-AGR-IN-004 and PR-TH-NR-AGR-IN-005)<br>*Note that the document number structure may vary for each company)<br>– Customer requirements'    
            ],

            [
                'ib_sub_category_scope_id' => 9,
                'name' => 'การตรวจในขั้นก่อนตรวจปล่อย,การตรวจในขั้นตรวจปล่อยในรายการต่อไปนี้',
                'name_en' => 'Pre-release inspection,Inspection at the release stage in the following items.',
                'standard' => '- มาตรฐานข้าวไทย (มาตรฐานสินค้าข้าว)<br>- เอกสารขั้นตอนการดําเนินงานของบริษัท หมายเลข QP-IN-01<br>- เอกสารขั้นตอนการปฏิบัติงานของบริษัท หมายเลข ….......( เช่น WI-IN-01 ถึง WI-IN-06) *ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>- ข้อกําหนดของลูกค้า' ,
                'standard_en' => '- Thai Rice Standard (Rice Product Standard)<br>- Company Operational Procedure Document No. QP-IN-01<br>- Company Work Instruction Document No. …....... (e.g., WI-IN-01 to WI-IN-06) *Note that the document numbering structure may vary by company<br>- Customer Requirements'    
            ],
            [
                'ib_sub_category_scope_id' => 10,
                'name' => 'การตรวจลักษณะทั่วไป และ,ปริมาณทั้งนี้ไม่รวมผลวิเคราะห์ในห้องปฏิบัติการ',
                'name_en' => 'General characteristics inspection,Quantity,Excluding laboratory analysis results.',
                'standard' => '– ขั้นตอนการดำเนินงานของบริษัท หมายเลข PR-TH-NR-AGR-IN-002 และ PR-TH-NR-AGR-IN-003<br>*ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป<br>– ข้อกำหนดของลูกค้า' ,
                'standard_en' => '– Company operating procedures, document numbers PR-TH-NR-AGR-IN-002 and PR-TH-NR-AGR-IN-003<br>*The document number structure may vary depending on each company<br>– Customer requirements'    
            ],
            [
                'ib_sub_category_scope_id' => 11,
                'name' => 'การตรวจสอบสภาพทั่วไป,การสุ่มตัวอย่าง,การสังเกตการณ์การชั่งน้ำหนัก',
                'name_en' => 'General condition inspection,Sampling,Observation of weighing.',
                'standard' => '– GAFTA Weighing Rules No. 123<br>– GAFTA Sampling Rules No. 124<br>– วิธีปฏิบัติงานของบริษัทหมายเลข PR-TH-NR-AGR-IN-006 *(ซึ่งของแต่ละบริษัทโครงสร้างหมายเลขเอกสารก็จะแตกต่างกันไป)<br>– ข้อกำหนดของลูกค้า' ,
                'standard_en' => '– GAFTA Weighing Rules No. 123<br>– GAFTA Sampling Rules No. 124<br>– Company Operating Procedure No. PR-TH-NR-AGR-IN-006 *(Note: Document number structure may vary by company)<br>– Customer Requirements'    
            ],
            [
                'ib_sub_category_scope_id' => 12,
                'name' => 'การสังเกตการณ์การชั่งน้ําหนัก,การเก็บตัวอย่างสินค้าชนิดเทกอง',
                'name_en' => 'Observation of weighing,Sampling of bulk products.',
                'standard' => '– GAFTA Weighing Rules No. 123<br>– GAFTA Sampling Rules No.124<br>- ขั้นตอนการดำเนินงานของหน่วยตรวจ หมายเลข .......<br>- ข้อกำหนดของลูกค้า' ,
                'standard_en' => '– GAFTA Weighing Rules No. 123<br>– GAFTA Sampling Rules No. 124<br>- Inspection Unit Operating Procedure No. .......<br>- Customer Requirements'    
            ],
            [
                'ib_sub_category_scope_id' => 13,
                'name' => 'การสังเกตการณ์การชั่งน้ำหนัก,การเก็บตัวอย่างสินค้าชนิดเทกอง',
                'name_en' => 'Observation of weighing,Sampling of bulk-type products.',
                'standard' => ' - GAFTA: Weighing Rules No. 123<br>- GAFTA: Sampling Rules No. 124<br>- เอกสารขั้นตอนการปฏิบัติงาน SOP-RI-06 (ISO / IEC 17020) เรื่อง: การตรวจสอบสินค้าตามมาตรฐาน<br>- เอกสารขั้นตอนการปฏิบัติงาน Gafta SOP-RI-04 (ISO / IEC 17020) ,เรื่อง : การปฏิบัติงานของผู้ตรวจตาม มาตรฐาน Gafta Rules No.123 และ 124' ,
                'standard_en' => '- GAFTA: Weighing Rules No. 123<br>- GAFTA: Sampling Rules No. 124<br>- Document on Standard Operating Procedure SOP-RI-06 (ISO/IEC 17020), Subject: Inspection of Goods According to Standards<br>- Document on Standard Operating Procedure Gafta SOP-RI-04 (ISO/IEC 17020), Subject: Operations of Inspectors According to Gafta Rules No. 123 and 124<br>'    
            ],
            [
                'ib_sub_category_scope_id' => 14,
                'name' => 'การตรวจลักษณะทั่วไป,การตรวจปริมาณ,การตรวจน้ำหนัก,การสุ่มเก็บตัวอย่าง,ทั้งนี้ไม่รวมถึงผลวิเคราะห์ในห้องปฏิบัติการ',
                'name_en' => 'General characteristics inspection,Quantity inspection,Weight inspection,Sampling,Excluding laboratory analysis results.',
                'standard' => ' - The Refined Sugar Association (RSA) Rules & Regulations<br>- วิธีการปฏิบัติงานของบริษัท หมายเลข IB-WI-IM-SU-006<br>- ข้อกําหนดของลูกค้า' ,
                'standard_en' => '- The Refined Sugar Association (RSA) Rules & Regulations<br>- Company Operating Procedure No. IB-WI-IM-SU-006<br>- Customer Requirements'  
            ],
            [
                'ib_sub_category_scope_id' => 15,
                'name' => 'การตรวจลักษณะทั่วไป,การสังเกตการณ์การชั่งน้ำหนัก,การเก็บตัวอย่างสินค้า,ทั้งนี้ไม่รวมการรมยาและการตรวจความสะอาด',
                'name_en' => 'General characteristics inspection,Observation of weighing,Product sampling,Excluding fumigation and cleanliness inspection.',
                'standard' => '- GAFTA Weighing Rules No. 123<br>- GAFTA Sampling Rules No. 124<br>- วิธีการปฏิบัติงานของบริษัท หมายเลข IB-WI-GI-GC-005<br>- วิธีการปฏิบัติงานของบริษัท หมายเลข IB-WI-IM-WP-008<br>- ข้อกําหนดของลูกค้า' ,
                'standard_en' => '- GAFTA Weighing Rules No. 123<br>- GAFTA Sampling Rules No. 124<br>- Company Operating Procedure No. IB-WI-GI-GC-005<br>- Company Operating Procedure No. IB-WI-IM-WP-008<br>- Customer Requirements'    
            ],
            [
                'ib_sub_category_scope_id' => 16,
                'name' => 'การตรวจในขั้นก่อนตรวจปล่อยและขั้นตรวจปล่อย ในรายการต่อไปนี้',
                'name_en' => 'Pre-release inspection and release inspection in the following items.<br>',
                'standard' => '- วิธีการปฏิบัติงานของบริษัท หมายเลข IB-WI-IM-TP-4<br>- ข้อกําหนดของลูกค้า' ,
                'standard_en' => '- Company Operating Procedure No. IB-WI-IM-TP-4<br>- Customer Requirements'   
            ]
          
        ]);
    }
}
