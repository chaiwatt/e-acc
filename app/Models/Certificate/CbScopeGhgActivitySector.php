<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeGhgActivitySector extends Model
{
    use Sortable;
    protected $table = "cb_scope_ghg_activity_sectors";
    protected $primaryKey = 'id';
    protected $fillable = [
        'cb_scope_ghg_activity_id',
        'cb_scope_ghg_sector_id',
    ];
}
