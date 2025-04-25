<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Expert; 
use App\ExpertBoard;
use App\ExpertMatch;
use App\ExpertEducation;
use App\RegisterExpertsExperiences;
use App\RegisterExpertsHistorys;
use Illuminate\Http\Request;

use HP; 
use Storage;
use stdClass;

use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use Cookie;
use URL;

class ExpertsController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ
    public function __construct()
    {
        $this->middleware('auth');
        $this->attach_path = 'files/expert';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {


        if(isset($request['session_id'])){//รับค่า session_id จาก form
            if(HP::CheckSession()){
                $data_session     =    HP::CheckSession();
                if($data_session->applicanttype_id == 2  && is_null($data_session->agent_id)){
                        $filter = [];
                        $filter['perPage'] = $request->get('perPage', 10);
            
                        $Query = new Expert;
                        $Query = $Query->where('created_by',   auth()->user()->getKey()) ;
                        $Query = $Query->whereNotIn('status',  ['7']) ;
                        $experts =  $Query->orderby('id','desc')
                                        ->sortable()
                                        ->paginate($filter['perPage']);
                        return view('experts.index', compact('experts'));
                }else{
                        return view('admin.index');
                }

            }else{
                $session_id = $request['session_id'] ;
                return $this->get_sso_and_set_session($session_id, $request);
            }
        }else{
            if(HP::CheckSession()){
                $data_session     =    HP::CheckSession();
                if($data_session->applicanttype_id == 2  && is_null($data_session->agent_id)){
                        $filter = [];
                        $filter['perPage'] = $request->get('perPage', 10);
            
                        $Query = new Expert;
                        $Query = $Query->where('created_by',   auth()->user()->getKey()) ;
                        $Query = $Query->whereNotIn('status',  ['7']) ;
                        $experts =  $Query->orderby('id','desc')
                                        ->sortable()
                                        ->paginate($filter['perPage']);
                        return view('experts.index', compact('experts'));
                }else{
                        return view('admin.index');
                }
            }else{

                //อ่านค่า session_id จาก cookie
                $config     = HP::getConfig();
                $session_id = Cookie::get($config->sso_name_cookie_login, null);

                if(!is_null($session_id)){//มีค่า
                    return $this->get_sso_and_set_session($session_id, $request);
                }else{
                    return redirect(HP::DomainTisiSso());
                }

            }
       }
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

            $data_session     =    HP::CheckSession();
            if($data_session->applicanttype_id == 2  && is_null($data_session->agent_id)){
                    $filter = [];
                    $filter['perPage'] = $request->get('perPage', 10);
        
                    $Query = new Expert;
                    $Query = $Query->where('created_by',   auth()->user()->getKey()) ;
                    $Query = $Query->whereNotIn('status',  ['7']) ;
                    $experts =  $Query->orderby('id','desc')
                                    ->sortable()
                                    ->paginate($filter['perPage']);
                    return view('experts.index', compact('experts'));
            }else{
                    return view('admin.index');
            }

        }else{
            return redirect($url_sso.'/login');
        }

    }


    public function create()
    {


        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
              $model = str_slug('experts','-');
            if(HP::CheckPermission('add-'.$model)){
                $user           = auth()->user();
                $expert         = new Expert;
                $educations     = [new ExpertEducation];
                $experiences    = [new RegisterExpertsExperiences];
                $historys       = [new RegisterExpertsHistorys];
            
            return view('experts.create', compact('user','educations','experiences','historys'));
        }
           abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
              $model = str_slug('experts','-');
            if(HP::CheckPermission('add-'.$model)){
 
            $user = auth()->user();
            $requestData = [];

            $requestData['head_name'] = !empty($request->head_name) ? $request->head_name : null;
            $requestData['taxid'] = !empty($request->taxid) ? $request->taxid : null;
            $requestData['head_address_no'] = !empty($request->head_address_no) ? $request->head_address_no : null;
            $requestData['head_soi'] = !empty($request->head_soi) ? $request->head_soi : null;
            $requestData['head_subdistrict'] = !empty($request->head_subdistrict) ? $request->head_subdistrict : null;
            $requestData['head_province'] = !empty($request->head_province) ? $request->head_province : null;
            $requestData['head_village'] = !empty($request->head_village) ? $request->head_village : null;
            $requestData['head_moo'] = !empty($request->head_moo) ? $request->head_moo : null;
            $requestData['head_district'] = !empty($request->head_district) ? $request->head_district : null;
            $requestData['head_zipcode'] = !empty($request->head_zipcode) ? $request->head_zipcode : null;

            $requestData['address_same_head'] = !empty($request->address_same_head) ? 1 : null;
            $requestData['contact_address_no'] = !empty($request->contact_address_no) ? $request->contact_address_no : null;
            $requestData['contact_soi'] = !empty($request->contact_soi) ? $request->contact_soi : null;
            $requestData['contact_subdistrict'] = !empty($request->contact_subdistrict) ? $request->contact_subdistrict : null;
            $requestData['contact_province'] = !empty($request->contact_province) ? $request->contact_province : null;
            $requestData['contact_village'] = !empty($request->contact_village) ? $request->contact_village : null;
            $requestData['contact_moo'] = !empty($request->contact_moo) ? $request->contact_moo : null;
            $requestData['contact_district'] = !empty($request->contact_district) ? $request->contact_district : null;
            $requestData['contact_zipcode'] = !empty($request->contact_zipcode) ? $request->contact_zipcode : null;
            $requestData['mobile_phone'] = !empty($request->mobile_phone) ? $request->mobile_phone : null;
            $requestData['email'] = !empty($request->email) ? $request->email : null;
            $requestData['department_id'] = !empty($request->department_id) ? $request->department_id : null;
            $requestData['position'] = !empty($request->position) ? $request->position : null;

            $requestData['historycv_text'] = !empty($request->historycv_text) ? json_encode(explode(",",$request->historycv_text))   : null;
            $requestData['trader_id'] = $user->id;
            $requestData['operation_id'] = $user->id;
            $requestData['created_by'] = $user->id;
            $requestData['state'] = 1;
            $requestData['status'] = 1;
            if(isset($request->pic_profile)){
                $pic_profile =  $this->storeFile($request->pic_profile, $requestData['taxid'],$request->pic_profile->getClientOriginalName());
                if(!is_null($pic_profile)){
                    $requestData['pic_profile'] =  $pic_profile ;
                }
              
            }
            
            $requestData['bank_name'] = !empty($request->bank_name) ? $request->bank_name : null;
            $requestData['bank_title'] = !empty($request->bank_title) ? $request->bank_title : null;
            $requestData['bank_number'] = !empty($request->bank_number) ? $request->bank_number : null;
            $requestData['token']      = str_random(16);
 
            $requestData['ref_no'] = HP::getExpertNextNo('ref_no','created_at');
            
            $requestData['created_by']   = $user->id;
            $expert                      = Expert::create($requestData);

                     
                if ($request->hasFile('bank_file')) {  //เอกสารหน้าบัญชี
                    HP::singleFileUpload(
                        $request->file('bank_file') ,
                        $this->attach_path,
                        (auth()->user()->tax_number ?? null),
                        (auth()->user()->name ?? null),
                        'E-ACC',
                        (  (new Expert)->getTable() ),
                        $expert->id,
                        'bank_file',
                        null
                    );
                }

                if ($request->hasFile('historycv_file')) {  //ไฟล์ประวัติความเชี่ยวชาญ (CV)
                    HP::singleFileUpload(
                        $request->file('historycv_file') ,
                        $this->attach_path,
                        (auth()->user()->tax_number ?? null),
                        (auth()->user()->name ?? null),
                        'E-ACC',
                        (  (new Expert)->getTable() ),
                         $expert->id,
                        'historycv_file',
                         null
                    );
                }

                $requestData = $request->all();
                if(isset($requestData['detail'])){  //ข้อมูลการศึกษา
                    self::get_detail($expert->id,$requestData['detail']);
                }
                if(isset($requestData['experience'])){  //ประสบการณ์
                    self::get_experience($expert->id,$requestData['experience']);
                }
                if(isset($requestData['history'])){  //ประวัติการดำเนินงานกับ สมอ.
                    self::get_history($expert->id,$requestData['history']);
                }

       
            return redirect('experts')->with('flash_message', 'เพิ่มเรียบร้อยแล้ว');
        }
        abort(403);  
      }else{
            return  redirect(HP::DomainTisiSso());  
      } 
    }

    public function show($token)
    {
        $model = str_slug('experts','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
           if(HP::CheckPermission('edit-'.$model)){
             $user = auth()->user();
              $expert = Expert::where('token', $token)->first();
              if(!is_null($expert) && !empty($expert->historycv_text)){
                    $historycv_text = json_decode($expert->historycv_text,true);
                    if(!is_null($historycv_text) && is_array($historycv_text)){
                        $expert->historycv_text = implode(",",$historycv_text);
                    }
                }
                    $educations = [new ExpertEducation];
                if(!is_null($expert) && count($expert->expert_education_many) >0){
                    $educations = $expert->expert_education_many;
                }
                $experiences = [new RegisterExpertsExperiences];
                if(!is_null($expert) && count($expert->expert_experiences_many) >0){
                    $experiences = $expert->expert_experiences_many;
                }
                $historys = [new RegisterExpertsHistorys];
                if(!is_null($expert) && count($expert->expert_historys_many) >0){
                    $historys = $expert->expert_historys_many;
                }
  
            return view('experts.show', compact('expert', 'user','educations','experiences','historys'));
        }
        abort(403);
    }else{
        return  redirect(HP::DomainTisiSso());  
    }
    }

    public function edit($token)
    {
        $model = str_slug('experts','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
           if(HP::CheckPermission('edit-'.$model)){
             $user = auth()->user();
              $expert = Expert::where('token', $token)->first();
              if(!is_null($expert) && !empty($expert->historycv_text)){
                    $historycv_text = json_decode($expert->historycv_text,true);
                    if(!is_null($historycv_text) && is_array($historycv_text)){
                        $expert->historycv_text = implode(",",$historycv_text);
                    }
                }
                    $educations = [new ExpertEducation];
                if(!is_null($expert) && count($expert->expert_education_many) >0){
                    $educations = $expert->expert_education_many;
                }
                $experiences = [new RegisterExpertsExperiences];
                if(!is_null($expert) && count($expert->expert_experiences_many) >0){
                    $experiences = $expert->expert_experiences_many;
                }
                $historys = [new RegisterExpertsHistorys];
                if(!is_null($expert) && count($expert->expert_historys_many) >0){
                    $historys = $expert->expert_historys_many;
                }
            return view('experts.edit', compact('expert', 'user','educations','experiences','historys'));
        }
        abort(403);
    }else{
        return  redirect(HP::DomainTisiSso());  
    }
    }


    public function update(Request $request, $id)
    {
 
        $model = str_slug('experts','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){
                try {  
                    
                    $user = auth()->user();
                    $requestData = [];
        
                    $requestData['head_name'] = !empty($request->head_name) ? $request->head_name : null;
                    $requestData['taxid'] = !empty($request->taxid) ? $request->taxid : null;
                    $requestData['head_address_no'] = !empty($request->head_address_no) ? $request->head_address_no : null;
                    $requestData['head_soi'] = !empty($request->head_soi) ? $request->head_soi : null;
                    $requestData['head_subdistrict'] = !empty($request->head_subdistrict) ? $request->head_subdistrict : null;
                    $requestData['head_province'] = !empty($request->head_province) ? $request->head_province : null;
                    $requestData['head_village'] = !empty($request->head_village) ? $request->head_village : null;
                    $requestData['head_moo'] = !empty($request->head_moo) ? $request->head_moo : null;
                    $requestData['head_district'] = !empty($request->head_district) ? $request->head_district : null;
                    $requestData['head_zipcode'] = !empty($request->head_zipcode) ? $request->head_zipcode : null;
        
                    $requestData['address_same_head'] = !empty($request->address_same_head) ? 1 : null;
                    $requestData['contact_address_no'] = !empty($request->contact_address_no) ? $request->contact_address_no : null;
                    $requestData['contact_soi'] = !empty($request->contact_soi) ? $request->contact_soi : null;
                    $requestData['contact_subdistrict'] = !empty($request->contact_subdistrict) ? $request->contact_subdistrict : null;
                    $requestData['contact_province'] = !empty($request->contact_province) ? $request->contact_province : null;
                    $requestData['contact_village'] = !empty($request->contact_village) ? $request->contact_village : null;
                    $requestData['contact_moo'] = !empty($request->contact_moo) ? $request->contact_moo : null;
                    $requestData['contact_district'] = !empty($request->contact_district) ? $request->contact_district : null;
                    $requestData['contact_zipcode'] = !empty($request->contact_zipcode) ? $request->contact_zipcode : null;
                    $requestData['mobile_phone'] = !empty($request->mobile_phone) ? $request->mobile_phone : null;
                    $requestData['email'] = !empty($request->email) ? $request->email : null;
                    $requestData['department_id'] = !empty($request->department_id) ? $request->department_id : null;
                    $requestData['position'] = !empty($request->position) ? $request->position : null;
        
                    $requestData['historycv_text'] = !empty($request->historycv_text) ? json_encode(explode(",",$request->historycv_text))   : null;
                    $requestData['trader_id'] = $user->id;
                    $requestData['operation_id'] = $user->id;
                    $requestData['updated_by'] = $user->id;
                    // $requestData['state'] = 1;
                    $requestData['status'] = 1;
                    if(isset($request->pic_profile)){
                        $pic_profile =  $this->storeFile($request->pic_profile, $requestData['taxid'],$request->pic_profile->getClientOriginalName());
                        if(!is_null($pic_profile)){
                            $requestData['pic_profile'] =  $pic_profile ;
                        }
                      
                    }
                    
                    $requestData['bank_name'] = !empty($request->bank_name) ? $request->bank_name : null;
                    $requestData['bank_title'] = !empty($request->bank_title) ? $request->bank_title : null;
                    $requestData['bank_number'] = !empty($request->bank_number) ? $request->bank_number : null;
 
                    $expert = Expert::findOrFail($id);
                    $expert->update($requestData);  

                     
                    if ($request->hasFile('bank_file')) {  //เอกสารหน้าบัญชี
                        HP::singleFileUpload(
                            $request->file('bank_file') ,
                            $this->attach_path,
                            (auth()->user()->tax_number ?? null),
                            (auth()->user()->name ?? null),
                            'E-ACC',
                            (  (new Expert)->getTable() ),
                            $expert->id,
                            'bank_file',
                            null
                        );
                    }
    
                    if ($request->hasFile('historycv_file')) {  //ไฟล์ประวัติความเชี่ยวชาญ (CV)
                        HP::singleFileUpload(
                            $request->file('historycv_file') ,
                            $this->attach_path,
                            (auth()->user()->tax_number ?? null),
                            (auth()->user()->name ?? null),
                            'E-ACC',
                            (  (new Expert)->getTable() ),
                             $expert->id,
                            'historycv_file',
                             null
                        );
                    }
    
                    $requestData = $request->all();
                    if(isset($requestData['detail'])){  //ข้อมูลการศึกษา
                        self::get_detail($expert->id,$requestData['detail']);
                    }
                    if(isset($requestData['experience'])){  //ประสบการณ์
                        self::get_experience($expert->id,$requestData['experience']);
                    }
                    if(isset($requestData['history'])){  //ประวัติการดำเนินงานกับ สมอ.
                        self::get_history($expert->id,$requestData['history']);
                    }
    
                    return redirect('experts')->with('flash_message', 'อัพเดทเรียบร้อยแล้ว');

                } catch (\Exception $e) {
                    return redirect('experts')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                }   
            }
            abort(403);

        }else{
            return  redirect(HP::DomainTisiSso());  
        }

    }


    public function get_detail($id , $requestData)
    {
        $data = (array)$requestData;
  
        //ลบที่ถูกกดลบ
        $data_id = array_diff($data['id'], [null]);
        ExpertEducation::when($data_id, function ($query, $data_id){
                        return $query->whereNotIn('id', $data_id);
                    })->delete();
        foreach($data['year'] as $key => $item) {
            if($item != ''){
                    $education = ExpertEducation::where('id', $data['id'][$key])->first();
                if(is_null($education)){
                    $education = new ExpertEducation;
                }
                    $education->expert_id       =   $id;
                    $education->year            =  $item;
                    $education->education_id    =  $data['education_id'][$key] ?? null;
                    $education->academy         =  $data['academy'][$key] ?? null;
                    $education->save();
                    if(!empty($data['file_education'][$key])){
                        $attach  = $data['file_education'][$key];
                        if(is_file($attach->getRealPath())){
                            HP::singleFileUpload(
                                $attach,
                                $this->attach_path,
                                (auth()->user()->tax_number ?? null),
                                (auth()->user()->name ?? null),
                                'E-ACC',
                                (  (new ExpertEducation)->getTable() ),
                                 $education->id,
                                'file_education',
                                 null
                            );

                         }
                    }
            }
        }
       
    }

    public function get_experience($id , $requestData)
    {
        $data = (array)$requestData;
  
        //ลบที่ถูกกดลบ
        $data_id = array_diff($data['id'], [null]);
        RegisterExpertsExperiences::when($data_id, function ($query, $data_id){
                        return $query->whereNotIn('id', $data_id);
                    })->delete();
        foreach($data['years'] as $key => $item) {
            if($item != ''){
                    $experience = RegisterExpertsExperiences::where('id', $data['id'][$key])->first();
                if(is_null($experience)){
                    $experience = new RegisterExpertsExperiences;
                }
                    $experience->expert_id        =   $id;
                    $experience->years            =  $item;
                    $experience->department_id    =  $data['department_id'][$key] ?? null;
                    $experience->position         =  $data['position'][$key] ?? null;
                    $experience->role             =  $data['role'][$key] ?? null;
                    $experience->save();
            }
        }
    }

    public function get_history($id , $requestData)
    {
        $data = (array)$requestData;
  
        //ลบที่ถูกกดลบ
        $data_id = array_diff($data['id'], [null]);
        RegisterExpertsHistorys::when($data_id, function ($query, $data_id){
                        return $query->whereNotIn('id', $data_id);
                    })->delete();
        foreach($data['operation_at'] as $key => $item) {
            if($item != ''){
                    $experience = RegisterExpertsHistorys::where('id', $data['id'][$key])->first();
                if(is_null($experience)){
                    $experience = new RegisterExpertsHistorys;
                }
                    $experience->expert_id        =   $id;
                    $experience->operation_at     =  HP::convertDate($item,true);
                    $experience->department_id    =  $data['department_id'][$key] ?? null;
                    $experience->committee_no     =  $data['committee_no'][$key] ?? null;
                    $experience->expert_group_id  =  $data['expert_group_id'][$key] ?? null;
                    $experience->position_id      =  $data['position_id'][$key] ?? null;
                    $experience->save();
            }
        }
    }





    public function update_document(Request $request)
    {
        
        $requestData = $request->all();

        $pathfile = 'files/Tempfile/experts';
        $obj = new stdClass;

        if( $request->hasFile('file') ){
            $file = $request->file('file');
            $file_extension = $file->getClientOriginalExtension();
            $storageName = str_random(10).'-date_time'.date('Ymd_hms') . '.' .$file_extension ;
            $storagePath = Storage::putFileAs( $pathfile, $file,  str_replace(" ","",$storageName) );
            $obj->file =  HP::getFileStorage($storagePath);
            $obj->file_odl =  $file->getClientOriginalName();
            $obj->file_path = $storagePath;
        }
 

        return response()->json( $obj );

    }

    
    public function CopyFile($old_path_file, $new_path_file)
    {
        if( !empty($old_path_file) &&  Storage::exists("/".$old_path_file)){

            $cut = explode("/", $old_path_file );
            $file_name = end($cut);
            $file_extension = pathinfo( $file_name , PATHINFO_EXTENSION );

            $path = $new_path_file.'/'.(str_random(10).'-date_time'.date('Ymd_hms') . '.').'.'.$file_extension;
            Storage::copy($old_path_file, $path );

            return $path;

        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    // public function show()
    // {
    //     $model = str_slug('experts', '-');
    //     if (auth()->user()->can('view-' . $model)) {
    //         $user = auth()->user();
    //         $expert = Expert::where('created_by', $user->id)->first();

    //         $status_data  = ['1'=>'ยื่นคำขอ','2'=>'อยู่ระหว่างการตรวจสอบคำขอ','3'=>'ตีกลับคำขอ','4'=>'ตรวจสอบคำขอแก้ไข','5'=>'เอกสารผ่านการตรวจสอบ','6'=>'อนุมัติการขึ้นทะเบียน','7'=>'ยกเลิกคำขอ','8'=>'ยกเลิกผู้เชี่ยวชาญ'];
    //         $status = $status_data[$expert->state];
    //         $expert_type = ExpertMatch::leftJoin('basic_expert_groups', function($join) {
    //             $join->on('register_expert_matchs.expert_type', '=', 'basic_expert_groups.id');
    //           })->where('expert_id', $expert->id)->pluck('basic_expert_groups.title');
    //         $board_type = ExpertBoard::leftJoin('basic_board_types', function($join) {
    //             $join->on('register_expert_board.board_type', '=', 'basic_board_types.id');
    //           })->where('expert_id', $expert->id)->pluck('basic_board_types.title');
    //         // dd($expert_type);
    //         if ($expert) {
    //             return view('experts.show', compact('expert', 'user','status','expert_type','board_type'));
    //         } else {
    //             return view('experts.index', compact('expert', 'user','status','expert_type','board_type'));
    //         }
    //     }
    //     abort(403);
    // }

    public function destroy($token)
    {
        
        $model = str_slug('experts','-');
        if(HP::CheckPermission('delete-'.$model)){
              $user = auth()->user();
              $result = Expert::where('token',$token)->update(['status'=>'7','deleted_by'=>$user->id,'deleted_at'=>  date('Y-m-d H:i:s')]);
            if($result){
                return redirect('experts')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว');
            }else{
                return "fail";
            }
        }else{
            return abort(403);
        }
    }

    public function detail()
    {
        $model = str_slug('experts','-');
        if(auth()->user()->can('view-'.$model)) {

            dd(HP::getExpertNextNo('ref_no','created_at'));

            $user = auth()->user();
            $expert = Expert::where('created_by',$user->id)->first();

            $status  = ['1'=>'ยื่นคำขอ','2'=>'อยู่ระหว่างการตรวจสอบคำขอ','3'=>'ตีกลับคำขอ','4'=>'ตรวจสอบคำขอแก้ไข','5'=>'เอกสารผ่านการตรวจสอบ','6'=>'อนุมัติการขึ้นทะเบียน','7'=>'ยกเลิกคำขอ','8'=>'ยกเลิกผู้เชี่ยวชาญ'];
            $expert_type = ExpertMatch::where('expert_id', $expert->id)->pluck('expert_type');
            $board_type = ExpertBoard::where('expert_id', $expert->id)->pluck('board_type');

            // dd($expert_type);

            if($expert){
                return view('experts/detail', compact('expert','user','status','expert_type','board_type'));

            }else{
                return view('experts.index', compact('expert','user','status','expert_type','board_type'));

            }
        }
        abort(403); 
    }

    public function storeFile($files,$tax_number='0000000000000',$prefix_name=null)
    {
        if ($files) {
            $attach_path  =  $this->attach_path;
            $fullFileName = $prefix_name.str_random(12).'_datetime'.date('Ymd_hms') . '.' . $files->getClientOriginalExtension();
            $storagePath = Storage::putFileAs($attach_path.'/'.$tax_number.'/', $files,  str_replace(" ","",$fullFileName) );
            $storageName = basename($storagePath); // Extract the filename
            return  $attach_path.'/'.$tax_number.'/'.$storageName;
        }else{
            return null;
        }
    }

    public function remove_file($type)
    {
        $user_login = auth()->user()->getKey();
        $expert  =  Expert::where('created_by',$user_login)->first();
        if(!is_null($expert)){
            $expert->historycv_file = null;
            $expert->bank_file = null;
            $expert->save();
             return   'true';
        }else{
            return   'false';
        }
    }

}
