<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbScopeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_scope_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('certi_ib_id')->nullable(); 
            $table->unsignedInteger('ib_main_category_scope_id')->nullable(); 
            $table->unsignedInteger('ib_sub_category_scope_id')->nullable(); 
            $table->unsignedInteger('ib_scope_topic_id')->nullable(); 
            $table->unsignedInteger('ib_scope_detail_id')->nullable(); 
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
        Schema::dropIfExists('ib_scope_transactions');
    }
}
