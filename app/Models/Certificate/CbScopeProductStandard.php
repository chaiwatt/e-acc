<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeProductStandard extends Model
{
    use Sortable;
    protected $table = "cb_scope_product_standards";
    protected $primaryKey = 'id';
    protected $fillable = [
        'cb_scope_product_id',
        'cb_scope_standard_id',
    ];
}
