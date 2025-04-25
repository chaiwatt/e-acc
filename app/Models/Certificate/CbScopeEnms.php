<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeEnms extends Model
{
    use Sortable;
    protected $table = "cb_scope_enms";
    protected $primaryKey = 'id';
    protected $fillable = [
        'activity_th',
        'activity_en'
    ];
}
