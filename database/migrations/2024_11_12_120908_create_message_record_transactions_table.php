<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRecordTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_record_transactions', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('board_auditor_id')->nullable();
            // $table->foreign('board_auditor_id')->references('id')->on('board_auditors')->onDelete('cascade');
            $table->unsignedInteger('board_auditor_id')->nullable(); // ต้องเป็น unsignedInteger แบบเดียวกับตาราง board_auditors
            $table->foreign('board_auditor_id')
                ->references('id')->on('board_auditors')
                ->onDelete('cascade'); // ลบข้อมูลเมื่อ board_auditor ถูกลบ
            $table->unsignedInteger('signer_id')->nullable(); // ต้องเป็น unsignedInteger แบบเดียวกับตาราง board_auditors
            $table->foreign('signer_id')
                ->references('id')->on('besurv_signers')
                ->onDelete('cascade'); // ลบข้อมูลเมื่อ board_auditor ถูกลบ
            $table->string('signature_id')->nullable();
            $table->char('app_id',20)->default(0);
            $table->char('certificate_type',10)->default(0);
            $table->char('is_enable',1)->default(0);
            $table->char('show_name',1)->default(0);
            $table->char('show_position',1)->default(0);
            $table->string('signer_name',250)->default(0);
            $table->string('signer_position',250)->default(0);
            $table->string('signer_order',250)->default(0);
            $table->string('file_path',250)->nullable();
            $table->char('page_no',2)->default(1);
            $table->string('pos_x',250)->default(0);
            $table->string('pos_y',250)->default(0);
            $table->char('linesapce',2)->default(20);
            $table->string('view_url',200)->nullable();
            $table->char('approval',1)->default(0);
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
        Schema::dropIfExists('message_record_transactions');
    }
}
