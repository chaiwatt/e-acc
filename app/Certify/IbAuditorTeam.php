<?php

namespace App\Certify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class IbAuditorTeam extends Model
{
    use Sortable;
    protected $table = "ib_auditor_teams";
    protected $primaryKey = 'id';
    protected $fillable = ['name','auditor_team_json','state'  ];
}
