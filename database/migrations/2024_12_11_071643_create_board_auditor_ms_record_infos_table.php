<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardAuditorMsRecordInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_auditor_ms_record_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('board_auditor_id')->nullable(); // ต้องเป็น unsignedInteger แบบเดียวกับตาราง board_auditors
            $table->foreign('board_auditor_id')
                ->references('id')->on('board_auditors')
                ->onDelete('cascade'); // ลบข้อมูลเมื่อ board_auditor ถูกลบ
            $table->string('header_text1')->nullable();
            $table->string('header_text2')->nullable();
            $table->string('header_text3')->nullable();
            $table->string('header_text4')->nullable();
            $table->string('body_text1')->nullable();
            $table->string('body_text2')->nullable();
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
        Schema::dropIfExists('board_auditor_ms_record_infos');
    }
}
