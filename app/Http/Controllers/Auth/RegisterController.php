<?php

namespace App\Http\Controllers\Auth;

use App\Profile;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail; 
use App\Mail\InformLtMail;
use App\Models\Basic\ConfigRoles as config_roles;
use App\RoleUser as role_user;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'trader_name' => 'required|string|max:255',
            'agent_email' => 'required|string|email|max:255|unique:users',
            // 'trader_password' => 'required|string|min:4|confirmed',
            'trader_password' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create($data)
    {
        return User::create([
        'trader_date' => date('Y-m-d'),
        'trader_inti' => $data['trader_inti'],
        'trader_operater_name' => $data['trader_operater_name'],
        'trader_type' => $data['trader_type'],
        'trader_name' => $data['trader_name'],
        'trader_id' => $data['trader_id'],
        'trader_id_register' => $data['trader_id_register']?Carbon::createFromFormat("d/m/Y",$data['trader_id_register'])->addYear(-543)->formatLocalized('%Y-%m-%d'):null,
        'trader_boss' => $data['trader_boss'],
        'trader_address' => $data['trader_address'],
        'trader_address_soi' => $data['trader_address_soi'],
        'trader_address_road' => $data['trader_address_road'],
        'trader_address_moo' => $data['trader_address_moo'],
        'trader_address_tumbol' => $data['trader_address_tumbol'],
        'trader_address_amphur' => $data['trader_address_amphur'],
        'trader_provinceID' => $data['trader_provinceID'],
        'trader_address_poscode' => $data['trader_address_poscode'],
        'trader_phone' => $data['trader_phone'],
        'trader_phone_to' => $data['trader_phone_to'],
        'trader_fax' => $data['trader_fax'],
        'trader_fax_to' => $data['trader_fax_to'],
        'trader_mobile' => $data['trader_mobile'],
        'agent_name' => $data['agent_name'],
        'agent_position' => $data['agent_position'],
        'agent_email' => $data['agent_email'],
        'agent_mobile' => $data['agent_mobile'],
        'agent_officephone' => $data['agent_officephone'],
        'agent_officephone_to' => $data['agent_officephone_to'],
        'agent_fax' => $data['agent_fax'],
        'agent_offficefax_to' => $data['agent_offficefax_to'],
        'date_of_data' => date('Y-m-d'),
        'trader_username' => $data['trader_username'],
        'trader_password' => $data['trader_password'],
        'trader_file_detial' => $data['trader_file_detial'],
        'trader_remark' => $data['trader_remark'],
        'trader_remarkby' => $data['trader_remarkby'],
        'trader_remarkdate' => $data['trader_remarkdate'],
        'created_at' => $data['created_at'],
        'deleted_at' => $data['deleted_at'],
        'params' => $data['params'],
        'updated_at' => $data['updated_at'],
        'remember_token' => $data['remember_token'],
        'is_nsw' => 'n'
        ]);
    }

    protected function registered(Request $request, $user)
    {
        if($user->profile == null){
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();
        }
        activity($user->name)
            ->performedOn($user)
            ->causedBy($user)
            ->log('Registered');
        $user->assignRole('user');
    }

      public function register(Request $request)
    {
        $user = User::create([
        'trader_date' => date('Y-m-d'),
        'trader_inti' => $request->trader_inti,
        'trader_operater_name' => $request->trader_operater_name,
        'trader_type' => $request->trader_type,
        'trader_name' => $request->trader_name,
        'trader_id' => $request->trader_id,
        'trader_id_register' => $request->trader_id_register?Carbon::createFromFormat("d/m/Y", $request->trader_id_register)->addYear(-543)->formatLocalized('%Y-%m-%d'):null,
        'trader_boss' => $request->trader_boss,
        'trader_address' => $request->trader_address,
        'trader_address_soi' => $request->trader_address_soi,
        'trader_address_road' => $request->trader_address_road,
        'trader_address_moo' => $request->trader_address_moo,
        'trader_address_tumbol' => $request->trader_address_tumbol,
        'trader_address_amphur' => $request->trader_address_amphur,
        'trader_provinceID' => $request->trader_provinceID,
        'trader_address_poscode' => $request->trader_address_poscode,
        'trader_phone' => $request->trader_phone,
        'trader_phone_to' => $request->trader_phone_to,
        'trader_fax' => $request->trader_fax,
        'trader_fax_to' => $request->trader_fax_to,
        'trader_mobile' => $request->trader_mobile,
        'agent_name' => $request->agent_name,
        'agent_position' => $request->agent_position,
        'agent_email' => $request->agent_email,
        'agent_mobile' => $request->agent_mobile,
        'agent_officephone' => $request->agent_officephone,
        'agent_officephone_to' => $request->agent_officephone_to,
        'agent_fax' => $request->agent_fax,
        'agent_offficefax_to' => $request->agent_offficefax_to,
        'date_of_data' => date('Y-m-d'),
        'trader_username' => $request->trader_username,
        'trader_password' => $request->trader_password,
        'trader_file_detial' => $request->trader_file_detial,
        'trader_remark' => $request->trader_remark,
        'trader_remarkby' => $request->trader_remarkby,
        'trader_remarkdate' => $request->trader_remarkdate,
        'created_at' => $request->created_at,
        'deleted_at' => $request->deleted_at,
        'params' => $request->params,
        'updated_at' => $request->updated_at,
        'remember_token' => $request->remember_token,
        'is_nsw' => 'n'
        ]);
        

        if($user){

             // เพิ่มสิทธิ์ roles   
             $config_roles  = config_roles::select('role_id')->where('group_type',2)->get();
             $role_user     = role_user::select('user_runrecno')->where('user_runrecno',$user->trader_autonumber)->get();
             if(count($config_roles) > 0 && count($role_user) == 0 ){
                    foreach($config_roles as $role){
                         $object                            = new role_user;
                         $object->role_id                   = $role->role_id;
                         $object->user_runrecno             = $user->trader_autonumber;
                         $object->save();
                    }
             }


            $this->set_mail($user);
            Auth::login($user);
            return redirect('/home')->with('flash_message', 'บันทึกข้อมูลสำเร็จ ลงทะเบียนเรียบร้อยแล้ว');
        } else {
            return back()->withInput()->withErrors(['ลงทะเบียนไม่สำเร็จ']);
        }

    }

    public function checkemailexits(Request $req)
    {
        $email = $req->email;
        $emailcheck = User::where('trader_username', $email)->count();
        if($emailcheck > 0)
        {
        echo "already";
        }
    }

    public function set_mail($user)
    {
        $mail = new RegisterMail(['email'=>  'e-Accreditation@tisi.mail.go.th' ?? '-',
                    'name'=>   !empty($user->trader_operater_name)  ? str_replace("บริษัท","", $user->trader_operater_name)  : '-',
                ]);

        $mail_lt = new InformLtMail(['email'=>  'e-Accreditation@tisi.mail.go.th' ?? '-',
                    'name'=>   !empty($user->trader_operater_name)  ? str_replace("บริษัท","", $user->trader_operater_name)  : '-',
                ]);

        if($user->agent_email){
            Mail::to($user->agent_email)->send($mail);
            // Mail::to('nsc@titi.mail.go.th')->send($mail_lt);
            Mail::to($user->agent_email)->send($mail_lt);
        }
    }

}
