<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class HtmlCbMemorandumRequest extends Model
{
    use Sortable;
    protected $table = 'html_cb_memorandum_requests';
    protected $primaryKey = 'id';

    protected $fillable = [
        'type','text1', 'text2'
    ];
}
