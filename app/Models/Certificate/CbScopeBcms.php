<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeBcms extends Model
{
    use Sortable;
    protected $table = "cb_scope_bcms";
    protected $primaryKey = 'id';
    protected $fillable = [
        'category',
        'activity_th',
        'activity_en'
    ];
}
