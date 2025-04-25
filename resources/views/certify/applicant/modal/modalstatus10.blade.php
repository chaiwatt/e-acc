{{-- work on Certify\ApplicantController --}}
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
      @if($certi->fullyApprovedAuditorNoCancels->count() > 0) 
        <a class="btn  btn-sm  form-group {{  $auditors_btn  }}" 
            href="{{url('certify/applicant/auditor/'.$token)}}" style="width:300px;">
            เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
        </a>
        @else
            
            <span class="text-warning">อยู่ระหว่างดำเนินการ...</span>
      @endif
            {{-- <a class="btn  btn-sm  form-group {{  $auditors_btn  }}" 
                 href="{{url('certify/applicant/auditor/'.$token)}}" style="width:300px;">
                  เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
           </a> --}}
            <br>
            @if(count($certi->cost_assessment_many) > 0 )
            @php 
                  $payin1_btn =  '';
              if($certi->CertiLabPayInOneStatus == "state3"){
                  $payin1_btn = 'btn-info';
              }elseif($certi->CertiLabPayInOneStatus == "state1"){
                  $payin1_btn =  'btn-danger';
              }elseif($certi->CertiLabPayInOneStatus == "state2"){
                  $payin1_btn = 'btn-success';
              }
          @endphp
            <div class="btn-group  form-group">
              <div class="btn-group">
                    <button type="button" class="btn {{$payin1_btn}} dropdown-toggle" data-toggle="dropdown" style="width:300px;">
                             แจ้งรายละเอียดค่าตรวจประเมิน <span class="caret"></span>
                     </button>
                     <div class="dropdown-menu" role="menu" >
                          @foreach($certi->cost_assessment_many as $key1 => $one)
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
                                      <a  class="btn {{$payin1_btn}} " href="{{ url("certify/applicant/Pay_In1/".$one->id."/".$certi->token)}}"  style="width:750px;text-align: left">
                                          {{  !empty($one->assessment->board_auditor_to->auditor) ? $one->assessment->board_auditor_to->auditor : '-'}}   
                                      </a> 
                                      <br>
                                  @endif
                          @endforeach
                     </div>
                </div>
             </div>
             @endif
              <br>
      
    @if(count($certi->notices) > 0 )
       @php 
           $assessment_btn =  '';
        if($certi->CertiLabSaveAssessmentStatus == "statusInfo" || $certi->CertiLabSaveAssessmentStatus == "statuPrimary"){
          $assessment_btn = 'btn-info';
        }elseif($certi->CertiLabSaveAssessmentStatus == "statusSuccess"){
           $assessment_btn = 'btn-success';
       }elseif($certi->CertiLabSaveAssessmentStatus == "statusDanger"){
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
                         @foreach($certi->notices as $key2 => $assessment)
                               @php 
                                     $report_status  = ['1'=>'แก้ไขข้อบกพร่อง/ข้อสังเกต','2'=>'การตรวจสอบประเมิน']; 
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
                                 
                                  if ($assessment->report_status == 1) { 
                                      $assessment_url = 'certify/applicant/assessment/'.base64_encode($assessment->id).'/'.$certi->token;;
                                  }else{
                                      $assessment_url = 'certify/applicant/inspection/'.base64_encode($assessment->id).'/'.$certi->token;;
                                  }
                                @endphp
                              <a  class="btn {{$assessment_btn}} " href="{{ url("$assessment_url")}}"  style="background-color:{{$assessment_btn}};width:750px;text-align: left">
                                 {{ $assessment->board_auditor_to->auditor ?? '-'}} 
                                 {{ array_key_exists($assessment->report_status,$report_status) ?  '( '.$report_status[$assessment->report_status].' )' :'' }}
                              </a> 
                             <br>
                          @endforeach
            
                       </div>
                  </div>
               </div>
               @endif
       
       
               {{-- {{$certi->fullyApprovedAuditors}} --}}
          {{-- </div> --}}
          {{-- <legend><h3>คณะผู้ตรวจประเมิน </h3></legend> --}}
          {{-- @if(count($certi->certi_auditors) > 0)  --}}
          @if($certi->fullyApprovedAuditors->count() > 0) 
                <legend><h3>คณะผู้ตรวจประเมิน  </h3>  </legend>
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
                            {{-- @foreach($certi->certi_auditors as $key => $item) --}}
                            @foreach($certi->fullyApprovedAuditors as $key => $item)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td>{{ $item->auditor ?? null }}</td>
                                <td>{{ $item->certi_lab_step_to->title ?? null }}</td>
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
      
      