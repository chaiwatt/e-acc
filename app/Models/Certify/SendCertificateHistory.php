<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class SendCertificateHistory extends Model
{
    use Sortable;
    protected $table = "certify_send_certificate_history";
    protected $primaryKey = 'id';
    protected $fillable = ['send_certificate_list_id', 'certificate_type','certificate_tb','certificate_id','certificate_path','certificate_file', 'certificate_newfile' , 'documentId' , 'signtureid' ,'app_no','name' ,'tax_id' ,'sign_id' ,'certificate_no'  ,'created_by','updated_by'];




}
