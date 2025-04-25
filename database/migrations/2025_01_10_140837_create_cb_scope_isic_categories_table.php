<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeIsicCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_isic_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('isic_id')->nullable(); 
            $table->char('category_code',10)->nullable();
            $table->char('description_th',200)->nullable();
            $table->char('description_en',200)->nullable();
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
        Schema::dropIfExists('cb_scope_isic_categories');
    }
}
