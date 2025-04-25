<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestBranchParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_branch_params', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('test_branch_category_id')->nullable();
            $table->string('name')->nullable()->comment('พารามิเตอร์');
            $table->string('name_eng')->nullable()->comment('พารามิเตอร์ Eng');
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
        Schema::dropIfExists('test_branch_params');
    }
}
