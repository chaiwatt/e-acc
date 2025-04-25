<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class PurposeType extends Model
{
    use Sortable;
    protected $fillable = [
        'name'
    ];
    protected $table = 'purpose_types';
    protected $primaryKey = 'id';


}
