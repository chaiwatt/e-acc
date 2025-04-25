<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\Formula;
class CertiCBFormulas  extends Model
{
    protected $table = 'app_certi_cb_formulas';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'title', 'formulas_id','image'
                          ];

 public function FormulaTo()
 {
     return $this->belongsTo(Formula::class,'formulas_id');
 }
   
                  
}
