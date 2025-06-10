<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingDocReviewAuditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_doc_review_auditors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracking_id');
            $table->string('doc_type')->default(1)->comment('1=cb, 2=ib');
            $table->string('team_name')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->char('type')->default('1');
            $table->string('file')->nullable();
            $table->string('filename')->nullable();
            $table->text('auditors')->nullable();
            $table->text('remark_text')->nullable();
            $table->char('status')->default('0');
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
        Schema::dropIfExists('tracking_doc_review_auditors');
    }
}
