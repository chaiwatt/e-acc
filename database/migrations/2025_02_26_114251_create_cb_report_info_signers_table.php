<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbReportInfoSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_report_info_signers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cb_report_info_id')->nullable(); 
            $table->foreign('cb_report_info_id')->references('id')->on('cb_report_infos')->onDelete('cascade');
            $table->unsignedInteger('signer_id')->nullable(); 
            $table->foreign('signer_id')->references('id')->on('besurv_signers')->onDelete('cascade');
            $table->char('app_id',20)->default(0);
            $table->char('certificate_type',10)->default(0)->comment('0=CB,1=IB,2=LAB');
            $table->string('signer_name',250)->default(0);
            $table->string('signer_position',250)->default(0);
            $table->string('signer_order',250)->default(0);
            $table->string('file_path',250)->nullable();
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
        Schema::dropIfExists('cb_report_info_signers');
    }
}
