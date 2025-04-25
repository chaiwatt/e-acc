<!-- Modal เลข 11 ประมาณค่าใช้จ่าย -->
<div class="modal fade text-left" id="action27{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">คำขอใบรับรอง  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
               
            </div>
            <div class="modal-body">
                @if(!is_null($report))
                {!! Form::open(['url' => 'certify/applicant/update/status_confirm/'.$token, 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]) !!}
                  <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('save_date', 'วันที่ประชุม : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-4 text-left">
                           <label for="" class="control-label  ">{{ !empty($report->meet_date) ? HP::DateThai($report->meet_date) :  null}}</label>
                           </div>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('save_date', 'รายละเอียด : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-4 text-left">
                           <label for="" class="control-label   ">{{!empty($report->desc) ?$report->desc :  null }}</label>
                           </div>
                       </div>
                     </div>
                   </div>
                   @if(!is_null($report->file_loa) && $report->file_loa != '')
                   <div class="row">
                       <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('files', 'หลักฐาน LOA : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-7 ">
                               <p> 
                                   <a href="{{ url('check/files/'.basename($report->file_loa)) }}"> 
                                   @php
                                       $type = strrchr(basename($report->file_loa),".");
                                   @endphp
                                   @if($type == ".pdf") 
                                   <i class="fa fa-file-pdf-o" style="font-size:20px; color:red" aria-hidden="true"></i>
                                   @else 
                                   <i  class="fa fa-file-word-o"  style="font-size:20px; color:#0000ff" aria-hidden="true"></i>
                                   @endif
                               </a>
                               </p>
                           </div>
                       </div>
                       </div>
                   </div>
                   @endif
                     @if(count($report->files) > 0)
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                            {!! Form::label('files', 'หลักฐานอื่นๆ : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                            <div class="col-md-7 ">
                                @foreach($report->files as  $key => $itme)
                                <p>รายละเอียดไฟล์ : {{ $itme->file_desc }}</p>
                                <p>หลักฐาน : <a href="{{ url('check/files/'.basename($itme->file)) }}"> 
                                    @php
                                        $type = strrchr(basename($itme->file),".");
                                    @endphp
                                    @if($type == ".pdf") 
                                    <i class="fa fa-file-pdf-o" style="font-size:20px; color:red" aria-hidden="true"></i>
                                    @else 
                                    <i  class="fa fa-file-word-o"  style="font-size:20px; color:#0000ff" aria-hidden="true"></i>
                                    @endif
                                    {{-- {{basename($itme->file)}} --}}
                                </a>
                                </p>
                                @endforeach
                            </div>
                        </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                               {!! Form::label('', '', ['class' => 'col-md-4 control-label  text-right']) !!}
                               <div class="col-md-4 text-left">
                                <label><input type="checkbox" checked id="status_confirm" name="status_confirm">&nbsp;ยืนยันคำขอรับใบรับรอง &nbsp;</label>
                               </div>
                           </div>
                         </div>
                       </div>
               

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success" >บันทึก</button>
                </div>
               {!! Form::close() !!}
               @endif
        </div>
    </div>
</div>


@push('js')
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
            $(document).ready(function () {
            //เพิ่มไฟล์แนบ
             $(".attach-add").unbind();
            $('.attach-add').click(function(event) {
                var box = $(this).next();
                console.log(box);
                
                box.find('.other_attach_item:first').clone().appendTo('#attach-box');

                box.find('.other_attach_item:last').find('input').val('');
                box.find('.other_attach_item:last').find('a.fileinput-exists').click();
                box.find('.other_attach_item:last').find('a.view-attach').remove();

                ShowHideRemoveBtn94(box);

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove', function(event) {
                var box = $(this).parent().parent().parent().parent();
                $(this).parent().parent().remove();
                ShowHideRemoveBtn94(box);
             
            });

            $('.attach-add').each(function(index,eve){
                var box = $(eve).next();
                ShowHideRemoveBtn94(box);
            });
           
        });

        function ShowHideRemoveBtn94(box) { //ซ่อน-แสดงปุ่มลบ
            if (box.find('.other_attach_item').length > 1) {
                box.find('.attach-remove').show();
            } else {
                box.find('.attach-remove').hide();
            }
        }

        // $('#btn11').on('click',function () {
        //     var dataDate = JSON.parse(JSON.parse(JSON.stringify($(this).attr('data-cost-date'))));
        //     var sumDate = 0;
        //     $('#costDate').empty();
        //     $.each(dataDate,function (index,value) {
        //         sumDate += value.amount_date;
        //         $('#costDate').append('<tr>' +
        //             '<td>'+value.desc+'</td>' +
        //             '<td class="text-center">'+value.amount_date+' วัน</td>' +
        //             '</tr>')
        //     });
        //     $('#totalDate').text(sumDate);
        //
        //     var dataItem = JSON.parse(JSON.parse(JSON.stringify($(this).attr('data-cost-item'))));
        //     var sumMoney = 0;
        //     $('#costItem').empty();
        //     $.each(dataItem,function (index,value) {
        //         sumMoney += (value.amount*value.amount_date);
        //         $('#costItem').append('<tr>' +
        //             '<td>'+value.desc+'</td>' +
        //             '<td class="text-center">'+formatMoney(value.amount)+'</td>' +
        //             '<td class="text-center">'+value.amount_date+' วัน</td>' +
        //             '</tr>')
        //     });
        //
        //     $('#totalMoney').text(formatMoney(sumMoney));
        //     $('#certiLab').val($(this).attr('data-id'));
        //
        // });

        $('.checkStatus').on('change',function () {
            console.log($(this).val());
            if ($(this).val() === "2"){
                $('#notAccept').fadeIn();
            }
            else {
                $('#notAccept').hide();
            }
        });

        // function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
        //     try {
        //         decimalCount = Math.abs(decimalCount);
        //         decimalCount = isNaN(decimalCount) ? 2 : decimalCount;
        //
        //         const negativeSign = amount < 0 ? "-" : "";
        //
        //         let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        //         let j = (i.length > 3) ? i.length % 3 : 0;
        //
        //         return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        //     } catch (e) {
        //         console.log(e)
        //     }
        // }

    </script>


@endpush