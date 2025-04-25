<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    //

    protected $table = "app_information";
    protected $fillable = [
                            'app_certi_lab_id',
                            'name',
                            'ages',
                            'nationality',
                            'alley',
                            'road',
                            'village_no',
                            'district',
                            'amphur	',
                            'nationality',
                            'alley',
                            'province',
                            'postcode',
                            'tel',
                            'identify_number',
                            'tax_indentification_number',
                            'address_headquarters',
                            'headquarters_alley',
                            'headquarters_road',
                            'headquarters_village_no',
                            'headquarters_district',
                            'headquarters_amphur',
                            'headquarters_province',
                            'headquarters_postcode',
                            'headquarters_tel',
                            'headquarters_tel_fax',
                            'date_regis_juristic_person',
                            'registration_number',
                            'commercial_registration',
                            'token'
                            ];
    public function certi_lab()
    {
       return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }
}
