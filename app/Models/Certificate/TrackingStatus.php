<?php

namespace App\Models\Certificate;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class  TrackingStatus extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_status";
    protected $primaryKey = 'id';
    protected $fillable = ['title'];

 


}
