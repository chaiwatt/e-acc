<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbScopeTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scope_std_name'); // ประเภท เช่น "เชิญประชุมอนุกรรมการวิชาการ"
            $table->string('scope_header_text')->nullable(); // ที่
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
        Schema::dropIfExists('cb_scope_templates');
    }
}
