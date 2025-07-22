<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeCorsia extends Model
{
    use Sortable;
    protected $table = "cb_scope_corsias";
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'sector',
        'sector_en', 
        'criteria'
    ];
}
