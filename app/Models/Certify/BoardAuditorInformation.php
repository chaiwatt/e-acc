<?php

namespace App\Models\Certify;

use App\Models\Bcertify\AuditorInformation;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class BoardAuditorInformation extends Model
{
    use Sortable;

    protected $fillable = ['group_id', 'auditor_id'];

    public function auditor() {
        return $this->belongsTo(AuditorInformation::class, 'auditor_id');
    }
}
