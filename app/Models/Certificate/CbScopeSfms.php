<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeSfms extends Model
{
    use Sortable;
    protected $table = "cb_scope_sfms";
    protected $primaryKey = 'id';
    protected $fillable = [
        'scope_th',
        'scope_en',
        'activity_th',
        'activity_en'
    ];
}

