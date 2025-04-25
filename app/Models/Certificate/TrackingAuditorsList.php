<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class  TrackingAuditorsList extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_auditors_list";
    protected $primaryKey = 'id';
    protected $fillable = ['auditors_status_id', 'user_id', 'temp_users', 'temp_departments','auditors_id' ,'status_id'];
}
