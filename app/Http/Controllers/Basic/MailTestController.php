<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use App\Mail\Basic\TestMail;
use Mail;
use File;

class MailTestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $config = config('mail');

        $config['from_address'] = $config['from']['address'];
        $config['from_name']    = $config['from']['name'];

        $config['send_to'] = $config['username'];
        $config['subject'] = 'ทดสอบส่งเมล';
        $config['body']    = 'เมลทดสอบจาก '.URL('/');

        return view('basic.mail-test.index', compact('config'));

    }

    public function send_mail(Request $request){

        $data   = $request->all();

        //ไฟล์แนบ
        $attach_path = null;
        if(array_key_exists('attach', $data)){
            $attach_folder = 'storage/uploads/tmp/'.uniqid();
            $attach_path   = $attach_folder.'/'.$data['attach']->getClientOriginalName();
            File::makeDirectory($attach_folder, $mode = 0777, true, true);
            File::copy($data['attach']->getPathName(), $attach_path);
        }

        $mail_format = new TestMail([
            'subject' => $data['subject'],
            'body' => $data['body'],
            'from_address' => $data['from_address'],
            'from_name' => $data['from_name'],
            'attach_path' => $attach_path
        ]);
        Mail::to($data['send_to'])->send($mail_format);

        //ลบไฟล์แนบ
        if(array_key_exists('attach', $data)){
            File::deleteDirectory($attach_folder);
        }

        return back()->withInput()->with('flash_message', 'ส่งอีเมลเรียบร้อยแล้ว');

    }

}
