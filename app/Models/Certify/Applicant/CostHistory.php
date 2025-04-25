<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;


class CostHistory extends Model
{


    protected $table = "cost_history";
    protected $fillable = ['app_certi_cost_id','person_id','details','file_scope', 'attachs','attachs_scope','status_scope','check_status','remark_scope','date'];

    public function cost() {
        return $this->belongsTo(Cost::class, 'app_certi_cost_id');
    }

    public function getMaxAmountDateAttribute() {
         $details =   json_decode($this->details);
         $count_date = [];
         if(count($details) > 0) {
            foreach($details  as $item){
                $amount_date = !empty($item->amount_date) ? $item->amount_date : 0 ;
                $count_date[] = $amount_date;

            }
         }
         return  max($count_date) ?? '-';
    }

    public function getSumAmountAttribute() {
        $details =   json_decode($this->details);
        $countItem = 0;
        if(count($details) > 0) {
           foreach($details  as $item){
               $amount_date = !empty($item->amount_date) ? $item->amount_date : 0 ;
               $amount = !empty($item->amount) ? $item->amount : 0 ;
               $countItem += ($amount*$amount_date);
           }
        }
        return  number_format($countItem,2) ?? '-';
   }
}
