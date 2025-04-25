<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbScopeTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_scope_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ib_sub_category_scope_id')->nullable(); 
            $table->foreign('ib_sub_category_scope_id')->references('id')->on('ib_sub_category_scopes')->onDelete('cascade');
            $table->text('name')->nullable();
            $table->text('name_en')->nullable();
            $table->text('standard')->nullable();
            $table->text('standard_en')->nullable();
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
        Schema::dropIfExists('ib_scope_topics');
    }
}
