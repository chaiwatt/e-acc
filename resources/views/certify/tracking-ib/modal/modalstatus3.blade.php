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
                 href="{{url('certify/tracking-ib/tracking-auditor/'.base64_encode($certi->id))}}" style="width:300px;">
                  เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
           </a>

           <br>
           @if(count($certi->tracking_payin_one_many) > 0 )
           @php 
                 $payin1_btn =  '';
             if($certi->CertiPayInOneStatus == "state3"){
                 $payin1_btn = 'btn-info';
             }elseif($certi->CertiPayInOneStatus == "state1"){
                 $payin1_btn =  'btn-danger';
             }elseif($certi->CertiPayInOneStatus == "state2"){
                 $payin1_btn = 'btn-success';
             }
         @endphp
           <div class="btn-group  form-group">
             <div class="btn-group">
                   <button type="button" class="btn {{$payin1_btn}} dropdown-toggle" data-toggle="dropdown" style="width:300px;">
                            แจ้งรายละเอียดค่าตรวจประเมิน <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" role="menu" >
                         @foreach($certi->tracking_payin_one_many as $key1 => $one)
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
                                     <a  class="btn {{$payin1_btn}} " href="{{ url("certify/tracking-ib/tracking-pay_in1/".base64_encode($one->id))}}"  style="width:750px;text-align: left">
                                         {{ $one->auditors_to->auditor ?? '-'}}   
                                     </a> 
                                     <br>
                                 @endif
                         @endforeach
                    </div>
               </div>
            </div>
            @endif
             <br>

             @if(count($certi->tracking_save_assessment_many) > 0 )
             @php 
                 $assessment_btn =  '';
              if($certi->CertiSaveAssessmentStatus == "statusInfo" || $certi->CertiSaveAssessmentStatus == "statuPrimary"){
                $assessment_btn = 'btn-info';
              }elseif($certi->CertiSaveAssessmentStatus == "statusSuccess"){
                 $assessment_btn = 'btn-success';
             }elseif($certi->CertiSaveAssessmentStatus == "statusDanger"){
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
                               @foreach($certi->tracking_save_assessment_many as $key2 => $assessment)
                                     @php 
                                        $bug_report  = ['1'=>'แก้ไขข้อบกพร่อง/ข้อสังเกต','2'=>'การตรวจสอบประเมิน']; 
                                            $assessment_btn =  '';
                                            $assessment_url =  '';
                                        if ($assessment->degree == 7 || $assessment->degree == 4) { // ผ่านการการประเมิน
                                            $assessment_btn =  'btn-info';
                                        }elseif (in_array($assessment->degree,[8])) {  //ฉบับร่าง
                                            $assessment_btn =  '#ffff80';
                                        }elseif (in_array($assessment->degree,[1,3,4,6])) {  //จนท. ส่งให้ ผปก.
                                            $assessment_btn =  'btn-danger';
                                        }else {    //ผปก. ส่งให้ จนท.
                                            $assessment_btn =  'btn-success';
                                        }
                                       
                                        if ($assessment->bug_report == 1) { 
                                            $assessment_url = 'certify/tracking-ib/assessment/'.base64_encode($assessment->id);
                                        }else{
                                            $assessment_url = 'certify/tracking-ib/evaluation/'.base64_encode($assessment->id);
                                        }
                                      @endphp
                                    <a  class="btn {{$assessment_btn}} " href="{{ url("$assessment_url")}}"  style="background-color:{{$assessment_btn}};width:750px;text-align: left">
                                       {{ $assessment->auditors_to->auditor ?? '-'}}  
                                       {{ array_key_exists($assessment->bug_report,$bug_report) ?  '( '.$bug_report[$assessment->bug_report].' )' :'' }}
                                    </a> 
                                   <br>
                                @endforeach
                  
                             </div>
                        </div>
                     </div>
                     @endif
             

      </div>
 
              </div>
          </div>
      </div>
      
      