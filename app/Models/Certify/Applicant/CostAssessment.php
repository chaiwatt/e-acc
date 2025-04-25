<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CostAssessment extends Model
{
    protected $table = "app_certi_lab_cost_assessments";
    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_assessment_id','app_certi_lab_id','amount','invoice',
                        'status_confirmed','reporter_id','report_date','amount_invoice','detail',
                        'file_client_name','invoice_client_name','amount_bill','conditional_type','remark',
                        'start_date_feewaiver','end_date_feewaiver','state'];

    public function assessment() {
        return $this->belongsTo(Assessment::class, 'app_certi_assessment_id');
    }

    public function CertiLabTo() {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }

    public function applicant() {
        return $this->belongsTo('App\User', 'app_certi_lab_id');
    }

    public function reporter() {
        return $this->belongsTo('App\User', 'reporter_id');
    }
    
    public function getDateFeewaiverAttribute() {
        $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $date = '';
        $start_date_feewaiver =  $this->start_date_feewaiver;
        $end_date_feewaiver =  $this->end_date_feewaiver;
      if(!is_null($start_date_feewaiver) &&!is_null($end_date_feewaiver)){
                 // ปี
                 $StartYear = date("Y", strtotime($start_date_feewaiver)) +543;
                 $EndYear = date("Y", strtotime($end_date_feewaiver)) +543;
                // เดือน
                $StartMonth= date("n", strtotime($start_date_feewaiver));
                $EndMonth= date("n", strtotime($end_date_feewaiver));
                //วัน
                $StartDay= date("j", strtotime($start_date_feewaiver));
                $EndDay= date("j", strtotime($end_date_feewaiver));
                if($StartYear == $EndYear){
                    if($StartMonth == $EndMonth){
                          if($StartDay == $EndDay){
                            $date =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear ;
                          }else{
                            $date =  $StartDay.'-'.$EndDay.' '.$strMonthCut[$StartMonth].' '.$StartYear ;
                          }
                    }else{
                        $date =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear.' - '.$EndDay.' '.$strMonthCut[$EndMonth].' '.$EndYear ;
                    }
                }else{
                    $date =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear.' - '.$EndDay.' '.$strMonthCut[$EndMonth].' '.$EndYear ;
                }
        }
        return $date;
      }
}
