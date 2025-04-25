<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class  TrackingAuditorsDate extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_auditors_date";
    protected $primaryKey = 'id';
    protected $fillable = ['auditors_id', 'start_date', 'end_date'];
}
