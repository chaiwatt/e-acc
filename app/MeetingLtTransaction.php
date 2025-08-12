<?php

namespace App;

use App\Models\Tis\EstandardOffers;
use Illuminate\Database\Eloquent\Model;

class MeetingLtTransaction extends Model
{
    protected $table = 'meeting_lt_transactions';
        protected $fillable = ['title',
                           'meeting_team_id',
                           'start_date',
                           'start_time',
                           'end_date',
                           'end_time',
                           'meeting_place',
                           'meeting_detail',
                           'attach',
                           'status_id',
                           'created_by',
                           'updated_by',
                           'meeting_group',
                           'budget',
                           'finish'
                        ];




   public function standardOffer($id)
    {
       return EstandardOffers::fins($id);
    }

}
