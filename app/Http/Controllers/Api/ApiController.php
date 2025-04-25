<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\Sessions;
use App\User;
use Session;
use Cookie;

class ApiController extends Controller
{

 public function Auth(Request $request){
    $input = $request->only(
                            'session_id',
                            'user_agent'
                            );
 
    return response()->json([
                    'status'=> '000',
                    'message'=> 'Found member login',
                    'result'=> $input
    ]);

  }



}
