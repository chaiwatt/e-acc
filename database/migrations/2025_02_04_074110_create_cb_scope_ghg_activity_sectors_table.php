<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeGhgActivitySectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_ghg_activity_sectors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cb_scope_ghg_activity_id')->nullable();
            $table->unsignedInteger('cb_scope_ghg_sector_id')->nullable();
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
        Schema::dropIfExists('cb_scope_ghg_activity_sectors');
    }
}
