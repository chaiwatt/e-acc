<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingLtTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_lt_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable()->comment('หัวข้อการประชุม');
            $table->integer('meeting_team_id')->nullable();
            $table->date('start_date')->nullable()->comment('วันที่นัดหมาย');
            $table->time('start_time')->nullable()->comment('เวลาที่นัดหมาย');
            $table->date('end_date')->nullable()->comment('วันที่สิ้นสุดนัดหมาย');
            $table->time('end_time')->nullable()->comment('เวลาที่สิ้นสุดนัดหมาย');
            $table->string('meeting_place', 255)->nullable()->comment('สถานที่นัดหมาย');
            $table->text('meeting_detail')->nullable()->comment('รายละเอียดวาระการประชุม');
            $table->text('attach')->nullable()->comment('เอกสารการประชุม');
            $table->text('meeting_group')->nullable()->comment('เอกสารการประชุม');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->double('budget',10,2)->nullable();
            $table->char('finish',5)->nullable();
            $table->integer('status_id')->nullable()->comment('สถานะการกำหนดมาตรฐาน 1.นัดหมายประชุม 2.บันทึกผลการประชุม 3.ยกเลิกนัดหมาย');
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
        Schema::dropIfExists('meeting_lt_transactions');
    }
}
