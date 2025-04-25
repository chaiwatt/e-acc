<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class BoardAuditorDate extends Model
{
    use Sortable;
    protected $table = "board_auditors_date";
    protected $primaryKey = 'id';
    protected $fillable = ['board_auditors_id', 'start_date', 'end_date'];
}
