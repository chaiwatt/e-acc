<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Cookie;
use HP; 
use URL; 
use App\Models2\Setting\Sessions;

class DashboardController extends Controller
{
    
    public function index(Request $request)
    {
  
      try {
               
            if(isset($request->session_id)  ){
                $session_id =  $request->session_id;
                $user_agent =  $request->user_agent;
                // $url        =  HP::getSettingUrl()->url_api_tisi_sso;
                $data       = array(
                                'session_id' => $session_id,
                                'user_agent' => $user_agent
                              );
                // $options = array(
                //         'http' => array(
                //             'header'  => "Content-type: application/x-www-form-urlencoded",
                //             'method'  => 'POST',
                //             'content' => http_build_query($data),
                //         ),
                //         "ssl"=>array(
                //             "verify_peer"=>false,
                //             "verify_peer_name"=>false,
                //         )
                // );
                // $context  = stream_context_create($options);
                // $json_data = file_get_contents($url, false, $context);
                // $api = json_decode($json_data); 
                // if(!empty($api->status) && $api->status == '000'){
                //      Session::put('_session_login', $data);
                //      $minutes    = 15; 
                //      Cookie::queue('session_login', $session_id,$minutes);
                //     return view('admin.index');  
                // }else{
                //     return  redirect(HP::getSettingUrl()->url_tisi_sso);  
                // }
                    //  Session::put('session_id', $session_id);
                    //  Session::put('user_agent', $user_agent);
                     $web_service = Sessions::where('id', $session_id)->where('user_agent', $user_agent)->first();
                if(!is_null($web_service)){
                     Session::put('_session_login', $data);
                     $minutes    = 15; 
                     Cookie::queue('session_login', $session_id,$minutes);
                    return view('admin.index');  
                }else{
                    return  redirect(HP::getSettingUrl()->url_tisi_sso);  
                }
            }else{
              
                if(HP::CheckSession()){
                    return view('admin.index');  
                }else{
                    return  redirect(HP::getSettingUrl()->url_tisi_sso);
                }
               
                  
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }
}
