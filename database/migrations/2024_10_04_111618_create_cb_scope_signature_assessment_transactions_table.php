<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeSignatureAssessmentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_signature_assessment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_cb_id')->nullable();
            $table->string('user_register_and_status')->nullable()->commnet('ข้อมูล json object');
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
        Schema::dropIfExists('cb_scope_signature_assessment_transactions');
    }
}
