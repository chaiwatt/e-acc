<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbDocReviewAuditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_doc_review_auditors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_cb_id');
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
        Schema::dropIfExists('cb_doc_review_auditors');
    }
}
