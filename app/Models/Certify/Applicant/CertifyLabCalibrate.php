<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Bcertify\CalibrationBranch;
use App\Models\Bcertify\CalibrationGroup;
class CertifyLabCalibrate extends Model
{
    protected $table = 'app_certify_lab_calibrates';
    protected $fillable = [
        'app_certi_lab_id',
        'branch_id',
        'group_id', // เหมือน type_id
        'token'
    ];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function certi_lab()
    {
        return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }

    public function getBranch(){
        return  DB::table('bcertify_calibration_branches')->select('*')->where('id',$this->branch_id)->first();
    }

    public function getGroup(){
        return  DB::table('bcertify_calibration_groups')->select('*')->where('id',$this->group_id)->first();
    }

    public function get_all_item(){
        return DB::table('app_certi_scope_calibrate_item')->select('*')->where('certi_calibrate_scope_id',$this->id)->get();
    }

    
    public function TableCalibrationBranch()
    {
        return $this->belongsTo(CalibrationBranch::class ,'branch_id');
    }
    public function TableCalibrationGroup()
    {
        return $this->belongsTo(CalibrationGroup::class ,'group_id');
    }

}
