<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class CertiCBReview extends Model
{
    protected $table = 'app_certi_cb_review';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'app_certi_cb_id', //TB: app_certi_cb
                            'files',
                            'review',
                            'attach',
                            'created_by',
                            'updated_by',
                            ];
public function FileReview1()
 {
    $tb = new CertiCBReview;
    return $this->belongsTo(CertiCBAttachAll::class,'id','ref_id')
                ->select('id','file')
                ->where('table_name',$tb->getTable())
                ->where('file_section',1)
                ->orderby('id','desc');
 }  
 public function FileReview2()
 {
    $tb = new CertiCBReview;
    return $this->belongsTo(CertiCBAttachAll::class,'id','ref_id')
                ->select('id','file')
                ->where('table_name',$tb->getTable())
                ->where('file_section',2)   
                 ->orderby('id','desc');
         
 }    
                         
}
