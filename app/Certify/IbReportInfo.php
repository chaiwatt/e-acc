<?php

namespace App\Certify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIBSaveAssessment;

class IbReportInfo extends Model
{
    use Sortable;
    protected $table = 'ib_report_infos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ib_assessment_id',
        'eval_riteria_text',
        'history',
        'insp_proc',
        'evaluation_key_point',
        'observation',
        'evaluation_result',
        'auditor_suggestion',
        'item_401_chk',
        'item_401_eval_select',
        'item_401_comment',
        'item_402_chk',
        'item_402_eval_select',
        'item_402_comment',
        'item_501_chk',
        'item_501_eval_select',
        'item_501_comment',
        'item_601_chk',
        'item_601_eval_select',
        'item_601_comment',
        'item_602_chk',
        'item_602_eval_select',
        'item_602_comment',
        'item_603_chk',
        'item_603_eval_select',
        'item_603_comment',
        'item_701_chk',
        'item_701_eval_select',
        'item_701_comment',
        'item_702_chk',
        'item_702_eval_select',
        'item_702_comment',
        'item_703_chk',
        'item_703_eval_select',
        'item_703_comment',
        'item_704_chk',
        'item_704_eval_select',
        'item_704_comment',
        'item_705_chk',
        'item_705_eval_select',
        'item_705_comment',
        'item_706_chk',
        'item_706_eval_select',
        'item_706_comment',
        'item_801_chk',
        'item_801_eval_select',
        'item_801_comment',
        'item_802_chk',
        'item_802_eval_select',
        'item_802_comment',
        'item_803_chk',
        'item_803_eval_select',
        'item_803_comment',
        'item_804_chk',
        'item_804_eval_select',
        'item_804_comment',
        'item_805_chk',
        'item_805_eval_select',
        'item_805_comment',
        'item_806_chk',
        'item_806_eval_select',
        'item_806_comment',
        'item_807_chk',
        'item_807_eval_select',
        'item_807_comment',
        'item_808_chk',
        'item_808_eval_select',
        'item_808_comment',
        'insp_cert_chk',
        'insp_cert_eval_select',
        'insp_cert_comment',
        'reg_std_mark_chk',
        'reg_std_mark_eval_select',
        'reg_std_mark_comment',
        'file',
        'file_client_name',
        'persons',
        'status',
    ];
    public function certiIBSaveAssessment(){
        return $this->belongsTo(CertiIBSaveAssessment::class, 'ib_assessment_id', 'id');
    }
}
