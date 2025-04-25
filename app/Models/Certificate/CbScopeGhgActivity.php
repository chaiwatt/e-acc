<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeGhgActivity extends Model
{
    use Sortable;
    protected $table = "cb_scope_ghg_activities";
    protected $primaryKey = 'id';
    protected $fillable = [
        'activity_th',
        'activity_en'
    ];
}
