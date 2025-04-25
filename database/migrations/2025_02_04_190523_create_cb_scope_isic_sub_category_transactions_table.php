<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeIsicSubCategoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_isic_sub_category_transactions', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('cb_scope_isic_category_transaction_id'); 

            // $table->unsignedInteger('cb_scope_isic_category_transaction_id')->nullable(); 
            // $table->foreign('cb_scope_isic_category_transaction_id')->references('id')->on('cb_scope_isic_category_transactions')->onDelete('cascade');

            $table->unsignedInteger('cb_scope_isic_category_transaction_id')->nullable();
            $table->foreign('cb_scope_isic_category_transaction_id', 'fk_cb_scope_isic_cat_txn')
                ->references('id')
                ->on('cb_scope_isic_category_transactions')
                ->onDelete('cascade');


            $table->unsignedInteger('subcategory_id');
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
        Schema::dropIfExists('cb_scope_isic_sub_category_transactions');
    }
}
