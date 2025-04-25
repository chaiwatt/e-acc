<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHtmlIbMemorandumRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('html_ib_memorandum_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->char('type')->nullable();
            $table->longText('text1')->nullable();
            $table->longText('text2')->nullable();
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
        Schema::dropIfExists('html_ib_memorandum_requests');
    }
}
