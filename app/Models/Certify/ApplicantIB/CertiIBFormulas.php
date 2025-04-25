<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\Formula;
class CertiIBFormulas  extends Model
{
    protected $table = 'app_certi_ib_formulas';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'title', 'formulas_id','image'
                          ];

 public function FormulaTo()
 {
     return $this->belongsTo(Formula::class,'formulas_id');
 }
   
                  
}
