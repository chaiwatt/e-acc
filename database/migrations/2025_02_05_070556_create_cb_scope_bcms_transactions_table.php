<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeBcmsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_bcms_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('certi_cb_id')->nullable();
            $table->unsignedInteger('bcms_id'); // ID ของหมวดหมู่ที่เลือก
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
        Schema::dropIfExists('cb_scope_bcms_transactions');
    }
}
