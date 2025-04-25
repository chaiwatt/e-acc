<div class="modal fade text-left" id="ib_doc_review_auditor_modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog " style="width:900px !important">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1"> เห็นชอบการแต่งตั้งคณะผู้ตรวจเอกสาร
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            <div class="modal-body"> 
                @php 
                    $auditors_btn =  '';
                    if($item->CertiAuditorsStatus == "statusInfo"){
                        $auditors_btn = 'btn-info';
                    }elseif($item->CertiAuditorsStatus == "statusSuccess"){
                        $auditors_btn =  'btn-success';
                    }else{
                        $auditors_btn = 'btn-danger';
                    }
                @endphp

                <table  class="table color-bordered-table primary-bordered-table" id="ib_doc_review_auditor_wrapper">
                    <thead>
                            <tr>
                                <th width="10%" >ลำดับ</th>
                                <th width="45%">ชื่อผู้ตรวจประเมิน</th>
                                <th width="45%">หน่วยงาน</th>
                            </tr>
                    </thead>
                    <tbody>
            

                    
                    </tbody>
                </table>
                
                <div class="form-group">
                    <input type="hidden" value="{{$item->id}}" id="certi_ib_id">
                    <div class="col-md-3">
                        <input type="radio" name="agree" value="1" id="agree" checked>
                        <label for="agree" class="control-label">เห็นชอบ</label>
                    </div>
                    <div class="col-md-6">
                        <input type="radio" name="agree" value="2" id="not_agree">
                        <label for="not_agree" class="control-label">ไม่เห็นชอบ</label>
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 25px">
                    <div class="row">
                        <div class="col-sm-12" id="text-area-wrapper" style="display: none;">
                            <label> หมายเหตุ : </label>
                            <textarea class="form-control" name="remark_map" id="remark" rows="4" ></textarea>
                        </div>
                        <div class="col-sm-12" >
                            <button type="button" data-ib_id="{{$item->id}}" class="btn btn-info waves-effect waves-light " style="margin-top:15px; float:right" id="agree_doc_review_tream">
                                บันทึก
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
