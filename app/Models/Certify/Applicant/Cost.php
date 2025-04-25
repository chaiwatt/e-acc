<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Certify\Applicant\CostHistory;
use App\Models\Certify\CertificateHistory;
use HP;
class Cost extends Model
{
    use Sortable;

    protected $table = "app_certi_lab_costs";
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_assessment_id', 'app_certi_lab_id', 'checker_id', 'draft', 'remark', 'agree', 
        'status_scope', 'attachs','check_status','remark_scope','amount','date','vehicle'
    ];

    public function assessment() {
        return $this->belongsTo(Assessment::class, 'app_certi_assessment_id');
    }

    public function applicant() {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }

    public function checker() {
        return $this->belongsTo('App\User', 'checker_id');
    }

    public function dates() {
        return $this->hasMany(CostDate::class, 'app_certi_cost_id');
    }

    public function items() {
        return $this->hasMany(CostItem::class, 'app_certi_cost_id');
    }

    public function files() {
        return $this->hasMany(CostFile::class, 'app_certi_cost_id');
    }

    public function CostHistory() {
        return $this->hasMany(CostHistory::class, 'app_certi_cost_id');
    }

    public function CertificateHistorys() {
        $ao = new Cost;
        return $this->hasMany(CertificateHistory::class,'ref_id', 'id')->where('table_name',$ao->getTable());
    }
    public function getSumAmountTotalAttribute() {
        $amounts = CostItem::where('app_certi_cost_id', $this->id)->sum('amount');
        if(is_null($amounts)){
            $amounts = null;
        }
        return $amounts ?? null;
   }

    public function getStatus() {
        if ($this->draft == 1) {
            return "ฉบับร่าง";
        }

        if ($this->agree == 1) {
            return "เห็นชอบ";
        } else if ($this->agree == 2) {
            return "ไม่เห็นชอบ";
        }

        return "รอความเห็นชอบ";
    }
}
