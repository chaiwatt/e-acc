<!-- Modal เลข 11 ประมาณค่าใช้จ่าย -->
<div class="modal fade text-left" id="actionEleven{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">ประมาณค่าใช้จ่าย</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php $count_date = [];
                      $countItem = 0 ;
                @endphp
                @foreach($items as $item)
                      @php $amount_date = !empty($item->amount_date) ? $item->amount_date : 0 ;
                           $amount = !empty($item->amount) ? $item->amount : 0 ;
                      @endphp
                   @php $count_date[] = $amount_date; @endphp
                   @php $countItem += ($amount*$amount_date); @endphp
                @endforeach
                <h6>1. จำนวนวันที่ใช้ตรวจประเมินทั้งหมด <span id="totalDate">{{  max($count_date) ?? '-' }}</span> วัน</h6>

                <h6>2. ค่าใช้จ่ายในการตรวจประเมินทั้งหมด <span id="totalMoney">{{ number_format($countItem,2) ?? '-' }}</span> บาท</h6>
                <div class="container-fluid">

                    <table class="table table-bordered" id="myTable_labTest">
                        <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white" width="2%">ลำดับ</th>
                            <th class="text-center text-white" width="38%">รายละเอียด</th>
                            <th class="text-center text-white" width="20%">จำนวนเงิน</th>
                            <th class="text-center text-white" width="20%">จำนวนวัน</th>
                            <th class="text-center text-white" width="20%">รวม (บาท)</th>
                        </tr>
                        </thead>
                        <tbody id="costItem">
                        @foreach($items as $key => $item)
                             @php     
                               $amount_date = !empty($item->amount_date) ? $item->amount_date : 0 ;
                               $amount = !empty($item->amount) ? $item->amount : 0 ;
                               $sum =   $amount*$amount_date 
                              @endphp
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>{{ $item->desc }}</td>
                                <td class="text-right">{{ number_format($amount, 2) }}</td>
                                <td class="text-right">{{ $amount_date }} วัน</td>
                                <td class="text-right">{{ number_format($sum, 2) ?? '-'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <footer>
                            <tr>
                                <td colspan="4" class="text-right">รวม</td>
                                <td class="text-right">
                                    {{ number_format($countItem,2) ?? '-' }}
                                </td>
                              
                            </tr>
                        </footer>
                    </table>
                </div>

                {!! Form::open(['url' => 'certify/applicant/update/status/cost', 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]) !!}

                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <p class="text-nowrap">เห็นชอบกับค่าใช่จ่ายที่เสนอมา</p>
                            </div>
                            <div class="col-md-9">
                                <label>{!! Form::radio('checkStatus', '1', true, ['class'=>'check checkStatus', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ยืนยัน &nbsp;</label>
                                <label>{!! Form::radio('checkStatus', '2', false, ['class'=>'check checkStatus', 'data-radio'=>'iradio_square-red']) !!} &nbsp;แก้ไข &nbsp;</label>
                            </div>
                        </div>

                        <div  style="display: none" id="notAccept">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label for="reason">ระบุเหตุผล :</label>
                                    <textarea name="reason" id="reason" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    {!! Form::label('another_modal_attach_files11', 'ไฟล์แนบ (ถ้ามี):', ['class' => 'm-t-5']) !!}
                                    <button type="button" class="btn btn-sm btn-success m-l-10 attach-add" id="attach-add">
                                        <i class="icon-plus"></i>&nbsp;เพิ่ม
                                    </button>
                                    <div id="modal_attach_box11">
                                        <div id="attach-box">
                                            <div class="form-group other_attach_item">
                                                <div class="col-md-5">
                                                    {!! Form::text('file_desc[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename"></span>
                                                        </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="fileinput-new">เลือกไฟล์</span>
                                                            <span class="fileinput-exists">เปลี่ยน</span>
                                                            {!! Form::file('another_modal_attach_files[]', null) !!}
                                                        </span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                                                    <button class="btn btn-danger btn-sm attach-remove" type="button" >
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </div>
                                             </div>
                                        </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>

                    </div>
                    @if(isset($cost) && $cost->attachs != '' && !is_null($cost->attachs)) 
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <p class="text-nowrap">เห็นชอบกับ Scope</p>
                            </div>
                             <div class="col-md-9">
                                <label>{!! Form::radio('status_scope', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ยืนยัน Scope&nbsp;</label>
                                <label>{!! Form::radio('status_scope', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ขอแก้ไข Scope&nbsp;</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-right">
                            
                            </div>
                                 @php
                                    $attachs = json_decode($cost->attachs);
                                @endphp
                            <div class="col-md-9">
                                @foreach($attachs as  $key => $itme)
                                        <p>รายละเอียดไฟล์ : {{ $itme->attachs_text }}</p>
                                        <p>ไฟล์แนบ : <a href="{{ url('certify/check/files/'.$itme->attachs) }}"> 
                                            @php
                                                $type = strrchr(basename($itme->attachs),".");
                                            @endphp
                                            @if($type == ".pdf") 
                                            <i class="fa fa-file-pdf-o" style="font-size:20px; color:red" aria-hidden="true"></i>
                                            @else 
                                            <i  class="fa fa-file-word-o"  style="font-size:20px; color:#0000ff" aria-hidden="true"></i>
                                            @endif
                                            {{basename($itme->attachs)}}
                                        </a>
                                        </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    @endif
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <p class="text-nowrap"> <span class="text-danger">*</span>  หมายเหตุ</p>
                            </div>
                             <div class="col-md-9" >
                                ค่าใช้จ่ายนี้เฉพาะการตรวจประเมินเท่านั้น ยังไม่รวมค่าใบคําขอและค่าใบรับรองหรือค่าใช้จ่ายอื่นๆ ที่เกี่ยวข้อง
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="certiLab" id="certiLab" value="{{$token}}">

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success" >บันทึก</button>
            </div>
            {!! Form::close() !!}
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