<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Tb10Trader;
use Illuminate\Database\Query\Builder;
use DB;
use App\Models\Basic\ConfigRoles as config_roles;
use App\RoleUser as role_user;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
      
        $user = User::where('trader_username', $request->email)->first(); // เช็ค username ในตาราง user_trader ว่ามีหรือไม่มี
        if(!is_null($user)){ // หากว่ามี เช็คต่อไปว่าถูกดึงมาจาก nsw หรือไม่
            if($user->is_nsw=='y'){ // ถูกดึงมาจาก nsw
              $check_username_trader = Tb10Trader::where('trader_id', $request->email)->first();
                if(!is_null($check_username_trader)){
                  if($check_username_trader->trader_password == $request->password){
                      Auth::login($user);
                  } else {
                    return back()->withInput()->withErrors(['ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง']);
                  }
                }
            } else if($user->is_nsw=='n') { // หากไม่ได้ดึง
                if($user->trader_password == $request->password){
                  Auth::login($user);
                } else {
                  return back()->withInput()->withErrors(['ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง']);
                }
            }
        } else { // หากว่า user ไม่มีในตาราง user_trader
          $tb10_nsw = Tb10Trader::where('trader_id', $request->email)
                  ->where('trader_password', $request->password)
                  ->first();
                  if(!is_null($tb10_nsw)){
                    $user_trader = User::create([
                       'trader_date' => $tb10_nsw->trader_date,
                        'trader_inti' => $tb10_nsw->trader_inti,
                        'trader_operater_name' => $tb10_nsw->trader_operater_name,
                        'trader_type' => $tb10_nsw->trader_type,
                        'trader_name' => $tb10_nsw->trader_name,
                        'trader_id' => $tb10_nsw->trader_id,
                        'trader_id_register' => $tb10_nsw->trader_id_register,
                        'trader_boss' => $tb10_nsw->trader_boss,
                        'trader_address' => $tb10_nsw->trader_address,
                        'trader_address_soi' => $tb10_nsw->trader_address_soi,
                        'trader_address_road' => $tb10_nsw->trader_address_road,
                        'trader_address_moo' => $tb10_nsw->trader_address_moo,
                        'trader_address_tumbol' => $tb10_nsw->trader_address_tumbol,
                        'trader_address_amphur' => $tb10_nsw->trader_address_amphur,
                        'trader_provinceID' => $tb10_nsw->trader_provinceID,
                        'trader_address_poscode' => $tb10_nsw->trader_address_poscode,
                        'trader_phone' => $tb10_nsw->trader_phone,
                        'trader_phone_to' => $tb10_nsw->trader_phone_to,
                        'trader_fax' => $tb10_nsw->trader_fax,
                        'trader_fax_to' => $tb10_nsw->trader_fax_to,
                        'trader_mobile' => $tb10_nsw->trader_mobile,
                        'agent_name' => $tb10_nsw->agent_name,
                        'agent_position' => $tb10_nsw->agent_position,
                        'agent_email' => $tb10_nsw->agent_email,
                        'agent_mobile' => $tb10_nsw->agent_mobile,
                        'agent_officephone' => $tb10_nsw->agent_officephone,
                        'agent_officephone_to' => $tb10_nsw->agent_officephone_to,
                        'agent_fax' => $tb10_nsw->agent_fax,
                        'agent_offficefax_to' => $tb10_nsw->agent_offficefax_to,
                        'date_of_data' => $tb10_nsw->date_of_data,
                        'trader_username' => $tb10_nsw->trader_id,
                        'trader_password' => null,
                        'trader_file_detial' => $tb10_nsw->trader_file_detial,
                        'trader_remark' => $tb10_nsw->trader_remark,
                        'trader_remarkby' => $tb10_nsw->trader_remarkby,
                        'trader_remarkdate' => $tb10_nsw->trader_remarkdate,
                        'created_at' => $tb10_nsw->created_at,
                        'deleted_at' => $tb10_nsw->deleted_at,
                        'params' => $tb10_nsw->params,
                        'updated_at' => $tb10_nsw->updated_at,
                        'remember_token' => $tb10_nsw->remember_token,
                        'is_nsw' => 'y'
                    ]);
                        if($user_trader){
                              // เพิ่มสิทธิ์ roles   
                              $config_roles   = config_roles::select('role_id')->where('group_type',1)->get();
                              $role_user      = role_user::select('user_runrecno')->where('user_runrecno',$user_trader->trader_autonumber)->get();
   
                              if(count($config_roles) > 0 && count($role_user) == 0 ){
                                      foreach($config_roles as $role){
                                          $object                            = new role_user;
                                          $object->role_id                   = $role->role_id;
                                          $object->user_trader_autonumber    = $user_trader->trader_autonumber;
                                          $object->save();
                                      }
                              }
                          $user = User::where('trader_id', $request->email)->first();
                          $check_username_trader = Tb10Trader::where('trader_id', $request->email)->first();
                            if(!is_null($check_username_trader)){
                              if($check_username_trader->trader_password == $request->password){
                                  Auth::login($user);
                              }
                            }
                        }
                  }
        }

        if(!is_null($user)){//login สำเร็จ

          if(is_null($user->profile)){//ถ้า profile ยังไม่มีข้อมูล
            $input_profile = [];
            $input_profile['trader_id'] = $user->getKey();

            $profile = new Profile;
            $profile->create($input_profile);
          }

        }else{
          return back()->withInput()->withErrors(['ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง']);
        }

      return redirect('/home')->with('message', 'บันทึกข้อมูลเรียบร้อยแล้ว');

    }

    public function authenticated(Request $request, $user)
    {
        activity($user->name)
            ->performedOn($user)
            ->causedBy($user)
            ->log('LoggedIn');
        if($user->hasRole('admin')){
            return redirect('home');
        }  else{
            return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        // $user = auth()->user();
        $user =  Auth::user();
        if(!is_null($user)){
        activity($user->name)
            ->performedOn($user)
            ->causedBy($user)
            ->log('LoggedOut');
        $this->guard()->logout();
        $request->session()->invalidate();
        }
        return redirect('/');
    }
}
