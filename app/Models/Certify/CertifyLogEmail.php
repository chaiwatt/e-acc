<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CertifyLogEmail extends Model
{
    use Sortable;
    protected $table = "app_certi_log_email";
    protected $primaryKey = 'id';
    protected $fillable = ['app_no','app_id', 'app_table', 'ref_id', 'ref_table','certify','subject','status','detail','email','email_to', 'email_cc','email_reply','user_id', 'agent_id','created_by','updated_by' ,'attach'  ];
 

}
