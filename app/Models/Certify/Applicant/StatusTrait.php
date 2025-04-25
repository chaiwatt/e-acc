<?php

namespace App\Models\Certify\Applicant;

trait StatusTrait {
    public static $STATUS_DRAFT = 0; // 0 - ฉบับร่าง
    public static $STATUS_WAIT_PROGRESS = 1; // 1 - รอดำเนินการตรวจสอบ
    public static $STATUS_PROGRESS = 2; // 2 - อยู่ระหว่างการตรวจสอบ
    public static $STATUS_DOCUMENT = 3; // 3 - ขอเอกสารเพิ่มเติม
    public static $STATUS_CANCEL_DOCUMENT = 4; // 4 - ยกเลิกเอกสาร
    public static $STATUS_NOT_PASS = 5; // 5 - ไม่ผ่านการตรวจสอบ
    public static $STATUS_PASS = 6; // 6 - ผ่านการตรวจสอบ
    public static $STATUS_WAIT_FEE = 7; // 7 - รอชำระค่าธรรมเนียม
    public static $STATUS_FEE = 8; // 8 - แจ้งชำระค่าธรรมเนียม
    public static $STATUS_REQUEST = 9; // 9 - รับคำขอ
    public static $STATUS_COST = 10; // 10 - ประมาณค่าใช้จ่าย
    public static $STATUS_COST_COMMENT = 11; // 11 - ขอความเห็นประมาณค่าใช้จ่าย
    public static $STATUS_AUDITOR_GROUP = 12; // 12 - แต่งตั้งคณะผู้ตรวจประเมิน
    public static $STATUS_AUDITOR_COMMENT = 13; // 13 - ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน
    public static $STATUS_AUDITOR_DETAIL = 14; // 14 - แจ้งรายละเอียดค่าตรวจประเมิน
    public static $STATUS_AUDITOR_FEE = 15; // 15 -  ชำระเงินค่าตรวจประเมิน
    public static $STATUS_AUDITOR_CHECK = 16; // 16 -  ตรวจสอบการชำระค่าตรวจประเมิน
    public static $STATUS_AUDITOR = 17; // 17 -  ตรวจประเมิน
    public static $STATUS_REPORT = 18; // 18 -  สรุปรายงานเสนออนุกรรมการ
    public static $STATUS_APP_COST_DETAIL = 19; // 19 -  แจ้งรายละเอียดชำระค่าใบรับรอง
    public static $STATUS_APP_COST = 20; // 20 -  ชำระค่าใบรับรอง
    public static $STATUS_APP_COST_CHECK = 21; // 21 -  ตรวจสอบชำระค่าใบรับรอง
    public static $STATUS_APP_EXPORT = 22; // 22 -  ออกใบรับรอง
    public static $STATUS_CONFIRM = 23; // 23 -  ยืนยันความถูกต้อง
    public static $STATUS_APP_EDIT = 24; // 24 -  แก้ไขใบรับรอง
    public static $STATUS_APP_EXPORT_SIGN = 25; // 25 -  ออกใบรับรองและลงนาม
    public static $STATUS_SIGNED = 26; // 26 -  ลงนามใบรับรองเรียบร้อย
}