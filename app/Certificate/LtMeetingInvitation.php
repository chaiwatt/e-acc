<?php

namespace App\Certificate;

use Illuminate\Database\Eloquent\Model;

class LtMeetingInvitation extends Model
{
       protected $table = 'lt_meeting_invitations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type',              // ประเภท เช่น "เชิญประชุมอนุกรรมการวิชาการ"
        'reference_no',      // หมายเลขอ้างอิง
        'date',              // วันที่
        'subject',           // เรื่อง
        'attachments',       // สิ่งที่ส่งมาด้วย
        'details',           // รายละเอียด
        'ps_text',           // รายละเอียด
        'qr_file_path',      // เก็บชื่อไฟล์ QR
        "google_form_qr",
        'committee_special_id', // รหัสคณะกรรมการพิเศษ
        'signer_id',         // รหัสผู้ลงนาม
        'signer_position',         // รหัสผู้ลงนาม
        'board_json',
        'standard_json',
        'status',
    ];

     protected $casts = [
        'standard_json' => 'array',
        'board_json' => 'array',
    ];



}
