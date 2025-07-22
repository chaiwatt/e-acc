<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbHtmlTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_html_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_cb_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('type_standard')->nullable();
            $table->string('petitioner')->nullable();
            $table->string('trust_mark')->nullable();
            $table->string('template_type')->nullable();
            $table->longText('html_pages')->nullable();
            $table->longText('json_data')->nullable();
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
        Schema::dropIfExists('cb_html_templates');
    }
}
