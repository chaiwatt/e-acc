<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopeMdms extends Model
{
       use Sortable;
    protected $table = "cb_scope_mdms";
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'code_sector',
        'activity_th', 
        'activity_en'
    ];
}

