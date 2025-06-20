<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingInvitationCommitteeSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_invitation_committee_specials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('meeting_invitation_id');
            $table->unsignedBigInteger('committee_special_id');
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
        Schema::dropIfExists('meeting_invitation_committee_specials');
    }
}
