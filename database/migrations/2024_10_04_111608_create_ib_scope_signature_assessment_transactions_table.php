<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbScopeSignatureAssessmentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_scope_signature_assessment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_ib_id')->nullable();
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
        Schema::dropIfExists('ib_scope_signature_assessment_transactions');
    }
}
