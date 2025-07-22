<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabHtmlTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_html_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_lab_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('according_formula')->nullable();
            $table->string('lab_ability')->nullable();
            $table->string('purpose')->nullable();
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
        Schema::dropIfExists('lab_html_templates');
    }
}
