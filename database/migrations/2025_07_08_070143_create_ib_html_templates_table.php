<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbHtmlTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_html_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_certi_ib_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('type_standard')->nullable();
            $table->string('standard_change')->nullable();
            $table->string('type_unit')->nullable();
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
        Schema::dropIfExists('ib_html_templates');
    }
}
