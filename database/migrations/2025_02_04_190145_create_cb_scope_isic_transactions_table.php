<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeIsicTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_isic_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('certi_cb_id')->nullable();
            $table->unsignedInteger('isic_id'); // ISIC ที่ถูกเลือก
            $table->boolean('is_checked')->default(false); // ถูกเลือกหรือไม่
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
        Schema::dropIfExists('cb_scope_isic_transactions');
    }
}
