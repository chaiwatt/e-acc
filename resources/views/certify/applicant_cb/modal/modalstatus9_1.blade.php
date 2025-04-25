<!-- Modal เลข 3 -->
<div class="modal fade text-left" id="TakeAction{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1"> แก้ไขเอกสาร
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
                
                <div class="form-group">
                    <label for="">{{$certi->doc_review_reject_message}}</label>
                </div>
                
                <div class="form-group" style="margin-top: 25px">
                    <div class="row">
                        <div class="col-sm-12" >
                            <a href="{{ url('/certify/applicant-cb/' . $item->token . '/edit') }}"  title="Edit ApplicantCB" class="btn btn-primary">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"> </i> แก้ไขเอกสาร
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

