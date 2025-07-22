<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabHtmlTemplate extends Model
{
     protected $table = 'lab_html_templates';

    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_lab_id','user_id','according_formula','lab_ability','purpose','html_pages', 'template_type','json_data'];
}

