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
    <a class="btn  btn-sm  form-group 
        {{ ($certi_cb->CertiAuditorsStatus == 'statusInfo')  ? 'btn-info' : 'btn-danger' }}" 
        href="{{url('certify/applicant-cb/auditor/'.$token)}}" style="width:300px;">
            เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
     </a>
      <br>
      @if(count($certi_cb->CertiCBPayInOneMany) > 0 )
      @php 
            $payin1_btn =  '';
        if($certi_cb->CertiCBPayInOneStatus == "state3"){
            $payin1_btn = 'btn-info';
        }elseif($certi_cb->CertiCBPayInOneStatus == "state1"){
            $payin1_btn =  'btn-danger';
        }elseif($certi_cb->CertiCBPayInOneStatus == "state2"){
            $payin1_btn = 'btn-success';
        }
    @endphp
      <div class="btn-group  form-group">
        <div class="btn-group">
              <button type="button" class="btn {{$payin1_btn}} dropdown-toggle" data-toggle="dropdown" style="width:300px;">
                       แจ้งรายละเอียดค่าตรวจประเมิน <span class="caret"></span>
               </button>
               <div class="dropdown-menu" role="menu" >
                 @foreach($certi_cb->CertiCBPayInOneMany as $key1 => $one)
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
                      <a  class="btn {{$payin1_btn}} " href="{{ url("certify/applicant-cb/Pay_In1/".$one->id."/".$certi_cb->token)}}"  style="width:750px;text-align: left">
                         {{ $one->CertiCBAuditorsTo->auditor ?? '-'}}
                      </a> 
                     <br>
                  @endforeach
    
               </div>
          </div>
       </div>
       @endif
        <br>

        @if(count($certi_cb->CertiCBSaveAssessmentMany) > 0 )
 @php 
     $assessment_btn =  '';
  if($certi_cb->CertiCBSaveAssessmentStatus == "statusInfo"){
    $assessment_btn = 'btn-info';
  }elseif($certi_cb->CertiCBSaveAssessmentStatus == "statusSuccess"){
     $assessment_btn = 'btn-success';
 }elseif($certi_cb->CertiCBSaveAssessmentStatus == "statusDanger"){
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
                   @foreach($certi_cb->CertiCBSaveAssessmentMany as $key2 => $assessment)
                         @php 
                            $bug_report  = ['1'=>'แก้ไขข้อบกพร่อง/ข้อสังเกต','2'=>'การตรวจสอบประเมิน']; 
                                $assessment_btn =  '';
                                $assessment_url =  '';
                            if ($assessment->degree == 7) { // ผ่านการการประเมิน
                                $assessment_btn =  'btn-info';
                            }elseif ($assessment->degree == 0) {  //ฉบับร่าง
                                $assessment_btn =  'btn-primary';
                            }elseif (in_array($assessment->degree,[1,3,4,6])) {  //จนท. ส่งให้ ผปก.
                                $assessment_btn =  'btn-danger';
                            }else {    //ผปก. ส่งให้ จนท.
                                $assessment_btn =  'btn-success';
                            }
                           
                            if ($assessment->bug_report == 1) { 
                                $assessment_url = 'certify/applicant-cb/assessment/'.$assessment->id;
                            }else{
                                $assessment_url = 'certify/applicant-cb/inspection/'.$assessment->id;
                            }
                          @endphp
        
                                <a  class="btn {{$assessment_btn}} " href="{{ url("$assessment_url")}}"  style="width:750px;text-align: left">
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

