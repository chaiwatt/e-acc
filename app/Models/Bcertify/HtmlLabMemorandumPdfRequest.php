<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class HtmlLabMemorandumPdfRequest extends Model
{
    use Sortable;
    protected $table = 'html_lab_memorandum_pdf_requests';
    protected $primaryKey = 'id';

    protected $fillable = [
        'type','text1', 'text2'
    ];
}
