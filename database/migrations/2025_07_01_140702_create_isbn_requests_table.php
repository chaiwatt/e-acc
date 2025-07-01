<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsbnRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isbn_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('standard_id');
            $table->string('request_no')->nullable(); 
            $table->string('tistype')->nullable(); 
            $table->string('tisno')->nullable(); 
            $table->string('tisname')->nullable(); 
            $table->string('page')->nullable(); 
            $table->string('cover_file')->nullable(); 
            $table->string('status')->nullable(); 
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
        Schema::dropIfExists('isbn_requests');
    }
}
