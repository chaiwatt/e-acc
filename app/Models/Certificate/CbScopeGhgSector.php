<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeGhgSector extends Model
{
    use Sortable;
    protected $table = "cb_scope_ghg_sectors";
    protected $primaryKey = 'id';
    protected $fillable = [
        'sector_th',
        'sector_en'
    ];
}

