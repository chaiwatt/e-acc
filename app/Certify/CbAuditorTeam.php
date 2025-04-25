<?php

namespace App\Certify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbAuditorTeam extends Model
{
    use Sortable;
    protected $table = "cb_auditor_teams";
    protected $primaryKey = 'id';
    protected $fillable = ['name','auditor_team_json','state'  ];

}

