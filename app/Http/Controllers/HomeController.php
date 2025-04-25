<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use Cookie;
use HP;
use URL;
class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     return view('/');
    // }

    public function index(Request $request)
    {
    //   try {
            if(isset($request['session_id'])){//รับค่า session_id จาก form
                if(HP::CheckSession()){
                    return view('admin.index');
                }else{
                    $session_id = $request['session_id'] ;
                    return $this->get_sso_and_set_session($session_id, $request);
                }
            }else{

                if(HP::CheckSession()){
                    return view('admin.index');
                }else{

                    //อ่านค่า session_id จาก cookie
                    $config = HP::getConfig();

                    $session_id = Cookie::get($config->sso_name_cookie_login, null);
                    
                    if(!is_null($session_id)){//มีค่า
                        
                        return $this->get_sso_and_set_session($session_id, $request);
                    }else{
                        // dd(HP::DomainTisiSso());
                        return redirect(HP::DomainTisiSso());
                    }

                }


            }
        // } catch (Exception $ex) {
        //      return  redirect(HP::DomainTisiSso());
        // }

    }

    //ดึงค่าข้อมูลผู้ที่ login จาก API ของ SSO
    private function get_sso_and_set_session($session_id, $request){
        
        $user_agent = $request->server('HTTP_USER_AGENT') ;

        $config     = HP::getConfig();
        $url_sso    = $config->url_sso;
        $url        = $url_sso.'api/v1/auth';

        $data = array(
                'session_id' => $session_id,
                'user_agent' => $user_agent
                );
         // 'content' => http_build_query($data),
        $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n".
                                 "app-name: $config->sso_eaccreditation_app_name\r\n".
                                 "app-secret: $config->sso_eaccreditation_app_secret",
                    'method'  => 'POST',

                    'content' => "session_id=$session_id&user_agent=$user_agent",
                ),
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                )
        );
        
        $context  = stream_context_create($options);
        
        $json_data = file_get_contents($url, false, $context);

        $api = json_decode($json_data);
        
        if(!empty($api->status) && $api->status == '000'){

            Session::put('_session_login', $data);
            $minutes = 15;
            Cookie::queue('session_login', $session_id,$minutes);

            $username = $api->result->username;
            $user = User::where('username', $username)->first();
            Auth::login($user);

            return view('admin.index');
        }else{
            return redirect($url_sso.'/login');
        }

    }

}
