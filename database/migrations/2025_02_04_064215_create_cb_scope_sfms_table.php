<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeSfmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_sfms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scope_th')->nullable();
            $table->string('scope_en')->nullable();
            $table->string('activity_th')->nullable();
            $table->string('activity_en')->nullable();

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
        Schema::dropIfExists('cb_scope_sfms');
    }
}
