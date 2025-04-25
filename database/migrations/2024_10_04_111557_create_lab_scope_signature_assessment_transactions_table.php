<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabScopeSignatureAssessmentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_scope_signature_assessment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('app_certi_lab_id')->nullable();
            $table->string('user_register_and_status')->nullable();
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
        Schema::dropIfExists('lab_scope_signature_assessment_transactions');
    }
}
