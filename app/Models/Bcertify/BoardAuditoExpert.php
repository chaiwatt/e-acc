<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use App\Models\Certify\BoardAuditor;
use Illuminate\Database\Eloquent\Model;

class BoardAuditoExpert extends Model
{
    use Sortable;
    protected $fillable = [
        'board_auditor_id',
        'expert'
    ];
    protected $table = 'board_audito_experts';
    protected $primaryKey = 'id';

    public function boardAuditor()
    {
        return $this->belongsTo(BoardAuditor::class, 'board_auditor_id', 'id');
    }
}

