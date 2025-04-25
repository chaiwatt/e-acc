                            <!-- Modal -->
                            <div class="modal fade in" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">{{ auth()->user()->trader_operater_name }}
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                       </h5>
                                    </div>
                                    <div class="modal-body">
                                      @if ($errors->any())
                                          <ul class="alert alert-danger">
                                                <p>ไม่ใช่ไฟล์ xls และ xslx กรุณาเลือกใหม่!</p>
                                          </ul>
                                      @endif
              
                                      <form method="post" enctype="multipart/form-data" action="{{ url('/esurv/inform_volume/import') }}">
                                       {{ csrf_field() }}
                                       <div class="form-group">
                                        <table class="table">
                                         <tr>
                                          <td width="75%">
                                            <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput">
                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-addon btn btn-default btn-file">
                                                 <span class="fileinput-new">เลือกไฟล์</span>
                                              <span class="fileinput-exists">เปลี่ยน</span>
                                              <input type="file" name="select_file"  required/>
                                              </span>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                            </div>
                                          </td>
                                          <td width="10%" align="left">
                                           <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                                          </td>
                                          <td width="15%" align="left">
                                              <b style="color: red;">.xls, .xslx</b> 
                                           </td>
                                         </tr>
                                        
                                        </table>
                                       </div>
                                      </form>
                                           <p><b>การผลิตตามเงื่อนไขใบอนุญาต ที่แจ้งปริมาณการผลิตแล้ว</b></p>
                                            <table id="customers">
                                            <thead>
                                              <tr>
                                                  <th width="2%" class="text-center">No.</th>
                                                  <th width="10%"  class="text-center">ใบอนุญาตเลขที่</th>
                                                  <th width="10%"  class="text-center">เดือน</th>
                                                  <th width="10%"  class="text-center">ปี</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td>No.</td>
                                                  <td>No.</td>
                                                 </tr>
                                              </tbody>
                                         </table>

                                         <p><b>การผลิตตามเงื่อนไขใบอนุญาต </b><b style="color: red"> ไม่สามารถบันทึกได้?</b></p>
                                         <table id="tbl_not_licenseNo">
                                         <thead>
                                           <tr>
                                               <th width="2%" class="text-center">No.</th>
                                               <th width="10%"  class="text-center">ใบอนุญาตเลขที่</th>
                                               <th width="10%"  class="text-center">เดือน</th>
                                               <th width="10%"  class="text-center">ปี</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                             <tr>
                                               <td>No.</td>
                                               <td>No.</td>
                                              </tr>
                                           </tbody>
                                      </table>

                                    </div>
                                    <div class="modal-footer">
                                     
                                    </div>
                                  </div>
                                </div>
                            </div>  