<?php

namespace App\Http\Controllers\Certify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certify\ApplicantCB\CertiCb;
class CheckController extends Controller
{
    public function check_mails($id)
    {
        $certi_cb =  CertiCb::where('id',$id)->first();
        return count($certi_cb->DataEmailDirectorCB);
    }
}
