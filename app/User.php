<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use App\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Kyslik\ColumnSortable\Sortable;
use App\RoleUser;
use App\Models\Certify\ApplicantCB\CertiCb;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Sortable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'sso_users';

    protected $primaryKey = 'id';

    // turn off both 
    public $timestamps = false;

    protected $fillable = [
        'name','username','password','email','contact_name','contact_tax_id','contact_prefix_name', 'contact_prefix_text', 'contact_first_name', 'contact_last_name', 'contact_tel','contact_fax','contact_phone_number',
        'block', 'sendEmail', 'registerDate','lastvisitDate', 'activation', 'params', 'lastResetTime', 'resetCount', 'otpKey', 'otep','requireReset',
        'applicanttype_id', 'date_niti','person_type', 'tax_number','nationality','date_of_birth','branch_code', 'prefix_name','prefix_text','person_first_name','person_last_name',
        'address_no', 'building','street', 'moo','soi','subdistrict','district','province','zipcode','country_code', 'tel', 'fax',
        'head_address_no','head_building','head_street','head_moo', 'head_soi','head_subdistrict', 'head_district','head_province','head_zipcode','head_country_code','head_tel','head_fax',
        'attfile','personfile','corporatefile', 'department_id', 'authorize_name','authorize_id_no','copy_card_authorize','agency_name', 'agency_id_no','agency_tel', 'copy_card_agency','letter_of_authority','authorize', 'authorize_data','system', 'requireSign', 'sign_img', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

   
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function permissionsList(){
        $roles = $this->roles;
        $permissions = [];
        foreach ($roles as $role){
            $permissions[] = $role->permissions()->pluck('name')->implode(',');
        }
       return collect($permissions);
    }

    public function permissions(){
        $permissions = [];
        $role = $this->roles->first();
        $permissions = $role->permissions()->get();
        return $permissions;
    }

    public function isAdmin(){
       $is_admin =$this->roles()->where('name','admin')->first();
       if($is_admin != null){
           $is_admin = true;
       }else{
           $is_admin = false;
       }
       return $is_admin;
    }
}
