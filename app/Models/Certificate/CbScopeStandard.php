<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeStandard extends Model
{
    use Sortable;
    protected $table = "cb_scope_standards";
    protected $primaryKey = 'id';
    protected $fillable = [
        'standard_th',
        'standard_en',
        'detail_th',
        'detail_en'
    ];
}

