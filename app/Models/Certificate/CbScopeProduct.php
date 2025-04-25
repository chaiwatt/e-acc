<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeProduct extends Model
{
    use Sortable;
    protected $table = "cb_scope_products";
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_th',
        'product_en'
    ];
}

