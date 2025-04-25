<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeOhsms extends Model
{
    use Sortable;
    protected $table = "cb_scope_ohsms";
    protected $primaryKey = 'id';
    protected $fillable = [
        'iaf',
        'activity_th',
        'activity_en'
    ];
}
