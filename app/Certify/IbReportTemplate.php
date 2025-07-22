<?php

namespace App\Certify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class IbReportTemplate extends Model
{
    use Sortable;
    protected $table = "ib_report_templates";
    protected $primaryKey = 'id';
    protected $fillable = ['ib_assessment_id','template','report_type','status'  ];
}
