<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Basic\Province;
use App\Models\Basic\District;
use App\Models\Basic\Amphur;

class Address extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    // protected $table = 'new_address';

    /**
    * The database primary key value.
    *
    * @var string
    */
    // protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'province_id', 
                            'province_name', 
                            'province_name_en', 
                            'district_id', 
                            'district_name', 
                            'district_name_en', 
                            'subdistrict_id', 
                            'subdistrict_name', 
                            'subdistrict_name_en'
                        ];

    // protected $appends = ['province_title', 'province_title_en', 'district_title', 'district_title_en', 'subdistrict_title', 'subdistrict_title_en'];

    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }
    
    public function district(){
        return $this->belongsTo(Amphur::class, 'district_id');
    }
    
    public function subdistrict(){
        return $this->belongsTo(District::class, 'subdistrict_id');
    }
    
    public function getProvinceTitleAttribute() {
        return @$this->province->PROVINCE_NAME;
    }
    
    public function getProvinceTitleEnAttribute() {
        return @$this->province->PROVINCE_NAME_EN;
    }
    
    public function getDistrictTitleAttribute() {
        return @$this->district->AMPHUR_NAME;
    }
    
    public function getDistrictTitleEnAttribute() {
        return @$this->district->AMPHUR_NAME_EN;
    }
    
    public function getSubDistrictTitleAttribute() {
        return @$this->subdistrict->DISTRICT_NAME;
    }
    
    public function getSubDistrictTitleEnAttribute() {
        return @$this->subdistrict->DISTRICT_NAME_EN;
    }

}