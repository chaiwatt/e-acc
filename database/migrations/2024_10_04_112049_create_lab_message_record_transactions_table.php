<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabMessageRecordTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_message_record_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('board_auditor_id')->nullable();
            $table->unsignedBigInteger('signer_id')->nullable();
            $table->string('signature_id')->nullable();
            $table->char('is_enable',1)->default(0);
            $table->char('show_name',1)->default(0);
            $table->char('show_position',1)->default(0);
            $table->string('signer_name',250)->default(0);
            $table->string('signer_position',250)->default(0);
            $table->string('signer_order',250)->default(0);
            $table->string('file_path',250)->nullable();
            $table->char('page_no',2)->default(1);
            $table->char('linesapce',2)->default(20);
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
        Schema::dropIfExists('lab_message_record_transactions');
    }
}
