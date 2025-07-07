<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HtmlTemplate extends Model
{
    protected $table = 'html_templates';

    protected $primaryKey = 'id';
    protected $fillable = ['html_pages', 'template_type'];
}
