<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbScopePersonalScope extends Model
{
    use Sortable;
    protected $table = "cb_scope_personal_scopes";
    protected $primaryKey = 'id';
    protected $fillable = [
        'txt_th',
        'txt_en',
    ];
}
