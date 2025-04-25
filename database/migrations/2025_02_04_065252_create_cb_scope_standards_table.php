<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_standards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('standard_th')->nullable();
            $table->string('standard_en')->nullable();
            $table->string('detail_th')->nullable();
            $table->string('detail_en')->nullable();
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
        Schema::dropIfExists('cb_scope_standards');
    }
}
