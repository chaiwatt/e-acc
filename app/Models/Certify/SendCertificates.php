<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use HP;
use DB;
use  App\Models\Besurv\Signer;
class SendCertificates extends Model
{
    use Sortable;
    protected $table = "certify_send_certificates";
    protected $primaryKey = 'id';
    protected $fillable = ['sign_name', 'sign_position','sign_check','sign_id','certificate_type','state','created_by','updated_by'  ];
 


    public function user_created(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function signer_to(){
        return $this->belongsTo(Signer::class, 'sign_id');
    }


    //จำนวนทั้งหมดใบรับรอง
    public function send_certificate_lists_many()
    {
        return $this->hasMany(SendCertificateLists::class,'send_certificate_id');
    }
     //จำนวนที่อนุมัติใบรับรอง
     public function send_certificate_lists_approve_many()
     {
         return $this->hasMany(SendCertificateLists::class,'send_certificate_id')->whereIn('sign_status',[3,4]);
     }
  
 
     public function getCertificateTypeTitleAttribute() {
        $certificate_type =  ['1'=>'CB','2'=>'IB','3'=>'LAB'];
       return array_key_exists($this->certificate_type,$certificate_type) ? $certificate_type[$this->certificate_type] : null;
   }
   
      public function getSendCertificateStatusAttribute() {
        $status = ['99'=>'ร่าง','1'=>'รอดำเนินการ','2'=>'อยู่ระหว่างยืนยันการลงนาม','3'=>'ลงนามใบรับรองเรียบร้อย'];
          return array_key_exists($this->state,$status) ? $status[$this->state] : null;
      }

      public function getSendCertificateListsUpdatedAttribute() {
            $request =  '..';
        if(count($this->send_certificate_lists_many) > 0){
            $ids = HP::getArrayFormSecondLevel($this->send_certificate_lists_many->toArray(), 'id');
            $certificate_lists = SendCertificateLists::select('sign_status', 'updated_at')->whereIn('id',$ids)->get();
            $date = [];
   
            if(count($certificate_lists) > 0){
                foreach($certificate_lists as $item){
            
                    if(in_array($item->sign_status,[3,4])){
                       $date[] =  $item->updated_at;
                    }
                }
       
                $request =  count($date) > 0 ? HP::DateThai(end($date))  : '' ;
            }
        }
        return $request;
      }

      
}
