<?php

namespace App\Models\Certify;

use App\Models\Bcertify\StatusAuditor;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class BoardAuditorGroup extends Model
{
    use Sortable;

    protected $fillable = ['board_auditor_id', 'status_auditor_id'];

    public function auditors() {
        return $this->hasMany(BoardAuditorInformation::class, 'group_id');
    }

    public function sa() {
        return $this->belongsTo(StatusAuditor::class, 'status_auditor_id');
    }
}
