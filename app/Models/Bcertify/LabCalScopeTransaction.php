<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\BranchLabAdress;
use App\Models\Bcertify\CalibrationBranch;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Bcertify\LabCalScopeUsageStatus;
use App\Models\Bcertify\CalibrationBranchParam1;
use App\Models\Bcertify\CalibrationBranchParam2;
use App\Models\Bcertify\CalibrationBranchInstrument;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;

class LabCalScopeTransaction extends Model
{
    use Sortable;
    protected $table = 'lab_cal_scope_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'branch_type', 
        'app_certi_lab_id', 
        'site_type',
        'branch_lab_adress_id',
        'bcertify_calibration_branche_id', 
        'calibration_branch_instrument_group_id', 
        'calibration_branch_instrument_id',
        'calibration_branch_parameter_one_id', 
        'parameter_one_value', 
        'calibration_branch_parameter_two_id',
        'parameter_two_value', 
        'cal_method', 
        'group',
    ];
    public function certiLab()
    {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id', 'id');
    }
    public function calibrationBranch()
    {
        return $this->belongsTo(CalibrationBranch::class, 'bcertify_calibration_branche_id', 'id');
    }
    public function calibrationBranchInstrumentGroup()
    {
        return $this->belongsTo(CalibrationBranchInstrumentGroup::class, 'calibration_branch_instrument_group_id', 'id');
    }
    public function calibrationBranchInstrument()
    {
        return $this->belongsTo(CalibrationBranchInstrument::class, 'calibration_branch_instrument_id', 'id');
    }
    public function calibrationBranchParam1()
    {
        return $this->belongsTo(CalibrationBranchParam1::class, 'calibration_branch_parameter_one_id', 'id');
    }
    public function calibrationBranchParam2()
    {
        return $this->belongsTo(CalibrationBranchParam2::class, 'calibration_branch_parameter_two_id', 'id');
    }
    public function usageStatus()
    {
        return $this->belongsTo(LabCalScopeUsageStatus::class, 'app_certi_lab_id', 'app_certi_lab_id')
                    ->where('group', $this->group);
    }

    public function branchLabAdress()
    {
        return $this->belongsTo(BranchLabAdress::class, 'branch_lab_adress_id', 'id');
    }

    protected $facilityTypes = [
        'pl_2_1' => 'สถานปฏิบัติการถาวร (Permanent facilities)',
        'pl_2_2' => 'สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities)',
        'pl_2_3' => 'สถานปฏิบัติการเคลื่อนที่ (Mobile facilities)',
        'pl_2_4' => 'สถานปฏิบัติการชั่วคราว (Temporary facilities)',
        'pl_2_5' => 'สถานปฏิบัติการหลายสถานที่ (Multi-site facilities)',
    ];

    public function getFacilityTypeDescription($input)
    {
        // ลบ `_branch` หรือ `_main` จาก input ก่อน
        $key = preg_replace('/_(branch|main)$/', '', $input);

        // คืนค่าประเภทสถานปฏิบัติการ ถ้าเจอใน array
        return $this->facilityTypes[$key] ?? 'Unknown facility type';
    }
}


