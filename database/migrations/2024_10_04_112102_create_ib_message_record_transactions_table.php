<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbMessageRecordTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_message_record_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_ib_id')->nullable();
            $table->unsignedBigInteger('user_register_id')->nullable();
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
        Schema::dropIfExists('ib_message_record_transactions');
    }
}
