<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestBranchCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_branch_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('bcertify_test_branche_id')->nullable();
            $table->string('name')->nullable()->comment('หมวดหมู่');
            $table->string('name_eng')->nullable()->comment('หมวดหมู่ Eng');
            $table->char('state',1)->default(1);
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
        Schema::dropIfExists('test_branch_categories');
    }
}
