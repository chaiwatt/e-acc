<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\Applicant\CertiLab;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabHtmlTemplate extends Model
{
     protected $table = 'lab_html_templates';

    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_lab_id','user_id','according_formula','lab_ability','purpose','html_pages', 'template_type','json_data'];

    public function certiLab(): BelongsTo
    {
        // Assuming the CertiLab model is named 'CertiLab' and the primary key is 'id'
        // and the foreign key in this table is 'app_certi_lab_id'
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }
}

