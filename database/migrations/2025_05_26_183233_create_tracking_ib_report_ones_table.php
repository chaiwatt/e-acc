<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingIbReportOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_ib_report_ones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracking_assessment_id')->nullable(); 
            $table->foreign('tracking_assessment_id')->references('id')->on('app_certi_tracking')->onDelete('cascade');

            //text
            $table->longText('eval_riteria_text')->nullable();
            $table->longText('background_history')->nullable();
            $table->longText('insp_proc')->nullable();
            $table->longText('evaluation_key_point')->nullable();
            $table->longText('observation')->nullable();
            $table->longText('evaluation_result')->nullable();
            $table->longText('auditor_suggestion')->nullable();

            // 10.4
            $table->char('item_401_chk', 5)->nullable();
            $table->char('item_401_eval_select', 1)->nullable();
            $table->char('item_401_comment', 255)->nullable(); 

            $table->char('item_402_chk', 5)->nullable();
            $table->char('item_402_eval_select', 1)->nullable();
            $table->char('item_402_comment', 255)->nullable();

            $table->char('item_501_chk', 5)->nullable();
            $table->char('item_501_eval_select', 1)->nullable();
            $table->char('item_501_comment', 255)->nullable();

            $table->char('item_601_chk', 5)->nullable();
            $table->char('item_601_eval_select', 1)->nullable();
            $table->char('item_601_comment', 255)->nullable();

            $table->char('item_602_chk', 5)->nullable();
            $table->char('item_602_eval_select', 1)->nullable();
            $table->char('item_602_comment', 255)->nullable();

            $table->char('item_603_chk', 5)->nullable();
            $table->char('item_603_eval_select', 1)->nullable();
            $table->char('item_603_comment', 255)->nullable();

            $table->char('item_701_chk', 5)->nullable();
            $table->char('item_701_eval_select', 1)->nullable();
            $table->char('item_701_comment', 255)->nullable();

            $table->char('item_702_chk', 5)->nullable();
            $table->char('item_702_eval_select', 1)->nullable();
            $table->char('item_702_comment', 255)->nullable();

            $table->char('item_703_chk', 5)->nullable();
            $table->char('item_703_eval_select', 1)->nullable();
            $table->char('item_703_comment', 255)->nullable();

            $table->char('item_704_chk', 5)->nullable();
            $table->char('item_704_eval_select', 1)->nullable();
            $table->char('item_704_comment', 255)->nullable();

            $table->char('item_705_chk', 5)->nullable();
            $table->char('item_705_eval_select', 1)->nullable();
            $table->char('item_705_comment', 255)->nullable();

            $table->char('item_706_chk', 5)->nullable();
            $table->char('item_706_eval_select', 1)->nullable();
            $table->char('item_706_comment', 255)->nullable();

            $table->char('item_801_chk', 5)->nullable();
            $table->char('item_801_eval_select', 1)->nullable();
            $table->char('item_801_comment', 255)->nullable();

            $table->char('item_802_chk', 5)->nullable();
            $table->char('item_802_eval_select', 1)->nullable();
            $table->char('item_802_comment', 255)->nullable();

            $table->char('item_803_chk', 5)->nullable();
            $table->char('item_803_eval_select', 1)->nullable();
            $table->char('item_803_comment', 255)->nullable();

            $table->char('item_804_chk', 5)->nullable();
            $table->char('item_804_eval_select', 1)->nullable();
            $table->char('item_804_comment', 255)->nullable();

            $table->char('item_805_chk', 5)->nullable();
            $table->char('item_805_eval_select', 1)->nullable();
            $table->char('item_805_comment', 255)->nullable();

            $table->char('item_806_chk', 5)->nullable();
            $table->char('item_806_eval_select', 1)->nullable();
            $table->char('item_806_comment', 255)->nullable();

            $table->char('item_807_chk', 5)->nullable();
            $table->char('item_807_eval_select', 1)->nullable();
            $table->char('item_807_comment', 255)->nullable();

            $table->char('item_808_chk', 5)->nullable();
            $table->char('item_808_eval_select', 1)->nullable();
            $table->char('item_808_comment', 255)->nullable();

            $table->char('insp_cert_chk', 5)->nullable();
            $table->char('insp_cert_eval_select', 1)->nullable();
            $table->char('insp_cert_comment', 255)->nullable();

            $table->char('reg_std_mark_chk', 5)->nullable();
            $table->char('reg_std_mark_eval_select', 1)->nullable();
            $table->char('reg_std_mark_comment', 255)->nullable();

            $table->string('file')->nullable();
            $table->string('file_client_name')->nullable();
            $table->longText('persons')->nullable();
            $table->longText('attached_files')->nullable();
            $table->char('status',1)->default(1);
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
        Schema::dropIfExists('tracking_ib_report_ones');
    }
}
