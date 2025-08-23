<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLtMeetingInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lt_meeting_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type'); // ประเภท เช่น "เชิญประชุมอนุกรรมการวิชาการ"
            $table->string('reference_no')->nullable(); // ที่
            $table->string('date')->nullable(); // วันที่
            $table->text('subject')->nullable(); // เรื่อง
            $table->text('attachments')->nullable(); // สิ่งที่ส่งมาด้วย
            $table->longText('details')->nullable(); // รายละเอียด
            $table->longText('ps_text')->nullable(); // รายละเอียด
            $table->string('qr_file_path')->nullable(); // เก็บชื่อไฟล์ QR
            $table->string('google_form_qr')->nullable(); 
            $table->unsignedInteger('signer_id')->nullable(); 
            $table->string('signer_position')->nullable(); // เก็บชื่อไฟล์ QR
            $table->char('status',1)->default(1);
            $table->longText('json_data')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lt_meeting_invitations');
    }
}
