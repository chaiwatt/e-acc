<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use  App\Models\Basic\Country;
class AuditorEducation extends Model
{

    use Sortable;
    protected $fillable = [
        'auditor_id',
        'year',
        'level_education',
        'major_education',
        'school_name',
        'country',
        'token',
    ];


    public function auditor(){
        return $this->belongsTo(AuditorInformation::class, 'auditor_id');
    }
    public function country_to(){
        return $this->belongsTo(Country::class, 'country');
    }
    public function getCountryNameAttribute() {
        return @$this->country_to->title.'  - '.@$this->country_to->title_en;
    }
    public function getEducationNameAttribute() {
      $level = ['1'=>'ป.ตรี','2'=>'ป.โท','3'=>'ป.เอก'];
      if(!is_null($this->level_education)){
        return  array_key_exists($this->level_education,$level) ? $level[$this->level_education] : ''  ;
      }else{
        return  ''  ;
      }
        
    }
}
