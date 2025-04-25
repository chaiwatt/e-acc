<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScopeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scope_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('sso_user_id')->comment('ID ผู้ใช้งาน');
            $table->string('detail')->nullable()->default(0)->comment('รายละเอียดขอบข่ายที่ต้องการ');
            $table->char('type',1)->default(0)->comment('0=LAB 1=CB 2=IB');
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
        Schema::dropIfExists('scope_requests');
    }
}
