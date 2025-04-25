<!-- Modal เลข 3 -->
<div class="modal fade text-left" id="TakeAction{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1"> อยู่ระหว่างดำเนินการ
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
<div class="modal-body"> 
    {{-- <div class="container-fluid"> --}}
 @php 
        $auditors_btn =  '';
    if($certi->CertiAuditorsStatus == "statusInfo"){
        $auditors_btn = 'btn-info';
    }elseif($certi->CertiAuditorsStatus == "statusSuccess"){
        $auditors_btn =  'btn-success';
    }else{
        $auditors_btn = 'btn-danger';
    }
@endphp
      <a class="btn  btn-sm  form-group {{  $auditors_btn  }}" 
           href="{{url('certify/applicant-cb/auditor_doc_review/'.$token)}}" style="width:320px;">
            เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
     </a>
      <br>
      @if(count($certi->CertiCBPayInOneMany) > 0 )
      @php 
            $payin1_btn =  '';
        if($certi->CertiCBPayInOneStatus == "state3"){
            $payin1_btn = 'btn-info';
        }elseif($certi->CertiCBPayInOneStatus == "state1"){
            $payin1_btn =  'btn-danger';
        }elseif($certi->CertiCBPayInOneStatus == "state2"){
            $payin1_btn = 'btn-success';
        }
    @endphp
      <div class="btn-group  form-group">
        <div class="btn-group">
              <button type="button" class="btn {{$payin1_btn}} dropdown-toggle" data-toggle="dropdown" style="width:300px;">
                       แจ้งรายละเอียดค่าตรวจประเมิน <span class="caret"></span>
               </button>
               <div class="dropdown-menu" role="menu" >
                    @foreach($certi->CertiCBPayInOneMany as $key1 => $one)
                        @php 
                                    $payin1_btn =  '';
                                if(is_null($one->state)){
                                    $payin1_btn = 'btn-warning';  
                                }elseif($one->status == 1){ // ผ่าน
                                    $payin1_btn = 'btn-info';  
                                }elseif($one->state == 1){  //จนท. ส่งให้ ผปก.
                                    $payin1_btn = 'btn-danger';  
                                }elseif($one->state == 2){   //ผปก. ส่งให้ จนท.
                                    $payin1_btn = 'btn-success';  
                                }
                            @endphp
                            @if ($one->status  != 3) 
                                <a  class="btn {{$payin1_btn}} " href="{{ url("certify/applicant-cb/Pay_In1/".$one->id."/".$certi->token)}}"  style="width:750px;text-align: left">
                                    {{ $one->CertiCBAuditorsTo->auditor ?? '-'}}   
                                </a> 
                                <br>
                            @endif
                    @endforeach
               </div>
          </div>
       </div>
       @endif
        <br>

        @if(count($certi->CertiCBSaveAssessmentMany) > 0 )
 @php 
     $assessment_btn =  '';
  if($certi->CertiCBSaveAssessmentStatus == "statusInfo" || $certi->CertiCBSaveAssessmentStatus == "statuPrimary"){
    $assessment_btn = 'btn-info';
  }elseif($certi->CertiCBSaveAssessmentStatus == "statusSuccess"){
     $assessment_btn = 'btn-success';
 }elseif($certi->CertiCBSaveAssessmentStatus == "statusDanger"){
    $assessment_btn =  'btn-danger';
 
 }else{
     $assessment_btn =  'btn-warning';
 }
@endphp
        <div class="btn-group  form-group">
          <div class="btn-group">
                <button type="button" class="btn {{$assessment_btn}} btn-succesdropdown-toggle" data-toggle="dropdown" style="width:300px;">
                    ผลการตรวจประเมิน <span class="caret"></span>
                 </button>
                 <div class="dropdown-menu" role="menu" >
                   @foreach($certi->CertiCBSaveAssessmentMany as $key2 => $assessment)
                         @php 
                            $bug_report  = ['1'=>'แก้ไขข้อบกพร่อง/ข้อสังเกต','2'=>'การตรวจสอบประเมิน']; 
                                $assessment_btn =  '';
                                $assessment_url =  '';
                            if ($assessment->degree == 7) { // ผ่านการการประเมิน
                                $assessment_btn =  'btn-info';
                            }elseif (in_array($assessment->degree,[8])) {  //ฉบับร่าง
                                $assessment_btn =  '#ffff80';
                            }elseif (in_array($assessment->degree,[1,3,4,6])) {  //จนท. ส่งให้ ผปก.
                                $assessment_btn =  'btn-danger';
                            }else {    //ผปก. ส่งให้ จนท.
                                $assessment_btn =  'btn-success';
                            }
                           
                            if ($assessment->bug_report == 1) { 
                                $assessment_url = 'certify/applicant-cb/assessment/'.$assessment->id.'/'.$certi->token;;
                            }else{
                                $assessment_url = 'certify/applicant-cb/inspection/'.$assessment->id.'/'.$certi->token;;
                            }
                          @endphp
                        <a  class="btn {{$assessment_btn}} " href="{{ url("$assessment_url")}}"  style="background-color:{{$assessment_btn}};width:750px;text-align: left">
                           {{ $assessment->CertiCBAuditorsTo->auditor ?? '-'}}  
                           {{ array_key_exists($assessment->bug_report,$bug_report) ?  '( '.$bug_report[$assessment->bug_report].' )' :'' }}
                        </a> 
                       <br>
                    @endforeach
      
                 </div>
            </div>
         </div>
         @endif
 
 
    {{-- </div> --}}
    <legend><h3>คณะผู้ตรวจประเมิน </h3></legend>
    @if(count($auditors) > 0) 
    <div class="row">
        <div class="col-md-12">
         <table class="table table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white" width="2%">ลำดับ</th>
                    <th class="text-center text-white" width="50%">คณะผู้ตรวจประเมิน</th>
                    <th class="text-center text-white" width="48%">สถานะ</th>
                </tr>
            </thead>
             <tbody>
                @foreach($auditors as $key => $item)
                <tr>
                    <td class="text-center">{{$key+1}}</td>
                    <td>{{ $item->auditor ?? null }}</td>
                    <td>{{ $item->CertiCBAuditorsStepTo->title ?? null }}</td>
                </tr>
                 @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endif
</div>
            {{-- <div class="modal-footer">
              
            </div> --}}
        </div>
    </div>
</div>

