<?php

namespace App\Models\Certify;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use HP;
 
class CertiEmailLt extends Model
{
    use Sortable;
    protected $table = "app_certi_email";
    protected $primaryKey = 'id';
    protected $fillable = ['certi','roles','cc','reply_to','emails','created_by','updated_by'];
  
}
