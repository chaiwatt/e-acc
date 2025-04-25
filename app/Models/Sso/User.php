<?php

namespace App\Models\Sso;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class User extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    // protected $table = 'tb10_nsw_lite_trader';
    protected $table = 'sso_users';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'name',
                            'username',
                            'password',
                            'picture',
                            'email',
                            'contact_name',
                            'contact_tax_id',
                            'contact_prefix_name',
                            'contact_prefix_text',
                            'contact_first_name',
                            'contact_last_name',
                            'contact_tel',
                            'contact_fax',
                            'contact_phone_number',
                            'contact_address_no',
                            'contact_building',
                            'contact_street',
                            'contact_moo',
                            'contact_soi',
                            'contact_subdistrict',
                            'contact_district',
                            'contact_province',
                            'contact_zipcode',
                            'contact_position',
                            'block',
                            'sendEmail',
                            'registerDate',
                            'lastvisitDate',
                            'params',
                            'lastResetTime',
                            'resetCount',
                            'applicanttype_id',
                            'date_niti',
                            'person_type',
                            'tax_number',
                            'nationality',
                            'date_of_birth',
                            'branch_code',
                            'branch_type',
                            'prefix_name',
                            'prefix_text',
                            'person_first_name',
                            'person_last_name',
                            'address_no',
                            'building',
                            'street',
                            'moo',
                            'soi',
                            'subdistrict',
                            'district',
                            'province',
                            'zipcode',
                            'tel',
                            'fax',
                            'personfile',
                            'corporatefile',
                            'remember_token',
                            'state',
                            'google2fa_status',
                            'google2fa_secret',
                            'latitude','longitude','juristic_status','check_api',
                            'name_en','address_en','moo_en','soi_en','street_en','subdistrict_en','district_en','province_en','zipcode_en',
                            'contact_address_en','contact_moo_en','contact_soi_en','contact_street_en','contact_subdistrict_en','contact_district_en','contact_province_en','contact_zipcode_en'
                        ];

    /*
      Sorting
    */
    public $sortable = [
                        'name', 'username', 'email', 'contact_name',
                        'applicanttype_id',
                        'tax_number',
                        'date_niti',
                        'branch_code',
                        'registerDate',
                        'lastvisitDate',
                       ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function states(){
        return [
                '1' => 'รอยืนยันตัวตนทาง E-mail',
                '2' => 'ยืนยันตัวตนแล้ว',
                '3' => 'รอเจ้าหน้าที่เปิดใช้งาน'
               ];
    }

    public function getStateNameAttribute() {
        $states = $this->states();
        return array_key_exists($this->state, $states) ? $states[$this->state] : '-' ;
    }

    public function getStateNameHtmlAttribute(){
        $states = [
                    '1' => 'danger',
                    '2' => 'success',
                    '3' => 'warning'
                  ];
        return array_key_exists($this->state, $states) ? '<span class=" text-'.$states[$this->state].'">'.$this->StateName.'</span>' : '-' ;
    }

    // ที่ตั้งสำนักงานใหญ่
    public function getFormatAddressAttribute() {
        $address   = [];
        $address[] = @$this->address_no;

            if($this->moo!='' && $this->moo !='-'  && $this->moo !='--'){
              $address[] =  "หมู่ที่ " . $this->moo;
            }
            if($this->soi!='' && $this->soi !='-'  && $this->soi !='--'){
                $address[] = "ซอย "  . $this->soi;
            }
            if($this->street !='' && $this->street !='-'  && $this->street !='--'){
                $address[] =  "ถนน "  . $this->street;
            }
            if($this->subdistrict!=''){
                $address[] =  (($this->province=='กรุงเทพมหานคร')?" แขวง":" ตำบล").$this->subdistrict;
             }

            if($this->district!=''){
                $address[] =  (($this->province=='กรุงเทพมหานคร')?" เขต":" อำเภอ").$this->district;
            }

            if($this->province=='กรุงเทพมหานคร'){
                $address[] =  " ".$this->province;
            }else{
                $address[] =  " จังหวัด".$this->province;
            }
            if($this->zipcode!=''){
                $address[] =  "รหัสไปรษณีย " . $this->zipcode;
            }
        return implode(' ', $address);
    }

    public function getApplicantTypeTitleAttribute() {
        $applicanttype =  ['1'=>'นิติบุคคล','2'=>'บุคคลธรรมดา','3'=>'คณะบุคคล','4'=>'ส่วนราชการ','5'=>'อื่นๆ'];
        return  array_key_exists($this->applicanttype_id,$applicanttype) ?  $applicanttype[$this->applicanttype_id] : null;
    }

    static function JuristicStatusList(){
        return [1 => 'ยังดำเนินกิจการอยู่', 2 => 'ฟื้นฟู', 3 => 'คืนสู่ทะเบียน', 4 => 'เลิกกิจการ'];
    }

    public function getJuristicStatusTextAttribute(){
        return array_key_exists($this->juristic_status, self::JuristicStatusList()) ? self::JuristicStatusList()[$this->juristic_status] : 'ไม่ทราบ' ;
    }

    public function getBranchTypeTitleAttribute() {
        $branch_types =  ['1' => 'สำนักงานใหญ่', '2' => 'สาขา'];
        return array_key_exists($this->branch_type,$branch_types)?$branch_types[$this->branch_type]:null;
    }

    public function getTypeaheadDropdownTitleAttribute() {
        $name = '';
        switch ($this->branch_type) {
            case 1:
                $name = $this->name.' | '.$this->tax_number.' | '.$this->BranchTypeTitle;
            break;
            case 2:
                $name = $this->name.' | '.$this->tax_number.' | '.$this->BranchTypeTitle.' ('.$this->branch_code.')';
            break;
            default:
                $name = $this->name.' | '.$this->tax_number;
        }
        return $name;
    }

    public function getContactFullNameAttribute() {
        return trim($this->contact_prefix_text).trim($this->contact_first_name).' '.trim($this->contact_last_name);
    }


}
