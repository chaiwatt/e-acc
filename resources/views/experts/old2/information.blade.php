<div class="row">
   <div class="col-md-12 ">
         <div class="form-group required{{ $errors->has('bank_file') ? 'has-error' : ''}}">
            {!! Form::label('bank_file', 'ระบุความเชี่ยวชาญ:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-8">
               <div class="input-group "> 
                  {!! Form::text('historycv_text', null , ['class' => 'form-control input_required',  'data-role'=>'tagsinput'  ,'id'=>'historycv_text']) !!}
                  {!! $errors->first('historycv_text', '<p class="help-block">:message</p>') !!}    
               </div>
               <span class="text-warning" style="font-size: 16px;">* กรณีมีความเชี่ยวชาญมากกว่า 1 ให้กด enter</span>  
            </div>
      </div>
  </div>
     <div class="col-md-12 ">
         <div class="form-group required{{ $errors->has('bank_file') ? 'has-error' : ''}}">
            {!! Form::label('bank_file', 'ไฟล์ประวัติความเชี่ยวชาญ (CV):', ['class' => 'col-md-3 control-label']) !!}
            @if (isset($expert) && $expert->AttachFileHistorycvFileTo)
            @php
            $attach = $expert->AttachFileHistorycvFileTo;
            @endphp
            <div class="col-md-8">
            <div class="form-group">
            <div class="col-md-12" style="padding-top: 7px; margin-bottom: 0; text-align: left">
                        {!! !empty($attach->caption) ? $attach->caption : '' !!}
                        <a href="{{url('funtions/get-view/'.$attach->url.'/'.( !empty($attach->filename) ? $attach->filename :  basename($attach->url)  ))}}" target="_blank" 
                                    title="{!! !empty($attach->filename) ? $attach->filename : 'ไฟล์แนบ' !!}" >
                                    {!! !empty($attach->filename) ? $attach->filename : '' !!}
                        </a>
            </div>
            </div>
            </div>
            @else
            <div class="col-md-8">
            <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                         <input type="file" name="historycv_file"  id="historycv_file" class="check_max_size_file input_required" required>
                        </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
            </div>
                        {!! $errors->first('bank_file', '<p class="help-block">:message</p>') !!}
            </div>
            @endif
      </div>
  </div>
</div>  