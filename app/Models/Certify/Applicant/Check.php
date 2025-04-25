<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Basic\Staff; 
class Check extends Model
{
    protected $table = "app_certi_lab_checks";
    protected $fillable = [
        'app_certi_lab_id', 'checker_id', 'desc', 'amount', 'invoice', 'reporter', 'report_date', 'state',
        'payment_file'
    ];
    protected $dates = [
        'report_date'
    ];

    public function applicant() {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }

    public function checker() {
        return $this->belongsTo('App\User', 'reporter_id');
    }

    public function files3() {
        return $this->hasMany(CheckFile::class, 'check_id')->where('status',3);
    }
    public function files4() {
        return $this->hasMany(CheckFile::class, 'check_id')->where('status',4);
    }
    public function files5() {
        return $this->hasMany(CheckFile::class, 'check_id')->where('status',5);
    }

    public function getChecker()
    {
        return $this->belongsTo(Staff::class, 'checker_id');
    }

    // วันที่ เจ้าหน้าที่มอนหมาย
    public function getResultReportDateAttribute() {

        $strDate = $this->report_date;
        if(is_null($strDate) || $strDate == '' || $strDate == '-' ){
            return '-';
        }
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("m", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $month = ['01'=>'มกราคม', '02'=>'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน', '05'=>'พฤษภาคม', '06'=>'มิถุนายน', '07'=>'กรกฎาคม', '08'=>'สิงหาคม', '09'=>'กันยายน', '10'=>'ตุลาคม', '11'=>'พฤศจิกายน', '12'=>'ธันวาคม'];
        $strMonthThai = $month[$strMonth];
        return "วันที่ $strDay เดือน $strMonthThai พ.ศ. $strYear";
      }
    /*
     * 1 - รอดำเนินการตรวจสอบ
     */
    public static function getCertiLabs() {
        return CertiLab::where('status', '>=', StatusTrait::$STATUS_WAIT_PROGRESS)->orderBy('created_at', 'desc');
    }
}
