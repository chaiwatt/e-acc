<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbAuditorTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ib_auditor_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('auditor_team_json')->nullable();
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
        Schema::dropIfExists('ib_auditor_teams');
    }
}
