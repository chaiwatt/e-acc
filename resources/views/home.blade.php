@extends('layouts.master')

@push('css')
    <link href="{{asset('plugins/components/owl.carousel/owl.carousel.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/components/owl.carousel/owl.theme.default.css')}}" rel="stylesheet" type="text/css"/>
    <style>
      .announce-tr td{
        padding-left:5px;
      }
      .bookmark{
        margin-top: 5px;
        margin-bottom: 5px;
      }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม(สมอ.)</div>
                    {{    Cookie::get('session_login') }}
                    <div class="panel-wrapper p-b-10 collapse in">
                      <div id="carousel-example-captions" data-ride="carousel" class="carousel slide">
                          <ol class="carousel-indicators">
                              <li data-target="#carousel-example-captions" data-slide-to="0" class="active"></li>
                              <li data-target="#carousel-example-captions" data-slide-to="1"></li>
                              <li data-target="#carousel-example-captions" data-slide-to="2"></li>
                          </ol>
                          <div role="listbox" class="carousel-inner">
                              <div class="item active">
                                <a href="https://www.tisi.go.th/website/service/e_license">
                                  <img src="{{asset('plugins/images/slide/01.png')}}" alt="First slide image" style="max-height:300px; width:100%;">
                                </a>
                              </div>
                              <div class="item">
                                <a href="https://www.tisi.go.th/website/about/e_license">
                                  <img src="{{asset('plugins/images/slide/02.png')}}" alt="Second slide image" style="max-height:300px; width:100%;">
                                </a>
                              </div>
                              <div class="item">
                                <a href="https://www.tisi.go.th/data/pdf/free_zone.pdf">
                                  <img src="{{asset('plugins/images/slide/03.png')}}" alt="Third slide image" style="max-height:300px; width:100%;">
                                </a>
                              </div>
                          </div>
                          <a href="#carousel-example-captions" role="button" data-slide="prev"
                             class="left carousel-control"> <span aria-hidden="true" class="fa fa-angle-left"></span>
                              <span class="sr-only">ก่อนหน้า</span>
                          </a>

                          <a href="#carousel-example-captions" role="button" data-slide="next"
                             class="right carousel-control"> <span aria-hidden="true" class="fa fa-angle-right"></span>
                              <span class="sr-only">ต่อไป</span>
                          </a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- .row -->
        <div class="row">

            <div class="col-md-8">
                <div class="white-box">

                  @php $blog = App\Blog::orderby('id', 'desc')->first(); @endphp

                  @if(!is_null($blog))
                      <h3><a href="{{ url('blogs/'.$blog->slug) }}">{{$blog->title}}</a></h3>
                      <span class="text-muted">โพสต์เมื่อ {{ HP::DateThai($blog->created_at) }}</span>
                      {!! HP::html_cut($blog->content, 5000) !!}

                          <a class="btn btn-info btn-sm" href="{{ url('blogs/'.$blog->slug) }}">อ่านต่อ...</a>



                      <div class="clearfix"></div>

                      <div class="details-wrapper">
							
							@if(!is_null($blog->author))
								<a href="{{url('blogs/author/'.$blog->author->id)}}">
									<span class="label label-success">ผู้เขียน : {{ $blog->author->reg_fname.' '.$blog->author->reg_lname }}</span>
								</a>
							@endif
							
							@if(!is_null($blog->author) && !is_null($blog->category))
								<a href="{{url('blogs/category/'.$blog->author->slug)}}">
									<span class="label label-primary">หมวดหมู่ : {{$blog->category->title}}</span>
								</a>
							@endif
									  
                          <div class="pull-right">
                              @if(count($blog->tags) > 0)
                                  @foreach($blog->tags as $tag)
                                      <a href="{{url('blogs/tag/'.$tag->slug)}}">
                                        <span class="label label-warning">{{$tag->name}}</span>
                                      </a>
                                  @endforeach
                              @endif
                          </div>
                          <div class="clearfix"></div>
                          <hr>
                      </div>
                  @else
                      <div><h3 align="center">ไม่มีบทความที่จะแสดง</h3></div>
                  @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="white-box">
                    <!-- START panel-->
                    <div class="panel panel-primary">
                        <div class="panel-heading">ประกาศ สมอ.</div>
                        <div class="panel-wrapper p-b-10 collapse in">

                            <table width="100%" border="0" cellspacing="1" cellpadding="1" style="font-size: 11px;">
                                <caption>&nbsp;</caption>
                                <tr class="announce-tr">
                                    <td valign="top">
                                      14/08/2562
                                    </td>
                                    <td>
                                      <a href="#" target="_blank">
                                        ประกาศสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม เรื่อง รายชื่อผู้สมัครเข้ารับการคัดเลือกข้าราชการพลเรือนสามัญเข้าสู่ระบบข้าราชการผู้มีผลสัมฤทธิ์สูง รุ่นที่ 15 ประจำปีงบประมาณ พ.ศ. 2562
                                      </a>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <hr class="bookmark" />
                                  </td>
                                </tr>
                                <tr class="announce-tr">
                                    <td valign="top">09/08/2562</td>
                                    <td>
                                      <a href="#" target="_blank">
                                        ประกาศสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม เรื่อง การขึ้นบัญชีและการยกเลิกบัญชีผู้ได้รับการคัดเลือกในตำแหน่งเจ้าพนักงานธุรการปฏิบัติงาน สังกัดสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม
                                      </a>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <hr class="bookmark" />
                                  </td>
                                </tr>
                                <tr class="announce-tr">
                                    <td valign="top">30/07/2562</td>
                                    <td>
                                      <a href="#" target="_blank">
                                        ประกาศคณะกรรมการดำเนินการนำรายชื่อผู้สอบแข่งขันได้ในตำแหน่งเจ้าพนักงานธุรการปฏิบัติงานไปขึ้นบัญชีเป็นผู้ได้รับการคัดเลือกในตำแหน่งเจ้าพนักงานธุรการปฏิบัติงานสังกัดสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม เรื่อง กำหนดวัน เวลา สถานที่ และวิธีการประเมินความเหมาะสมกับตำแหน่ง
                                      </a>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <hr class="bookmark" />
                                  </td>
                                </tr>
                                <tr class="announce-tr">
                                    <td valign="top">26/07/2562</td>
                                    <td>
                                      <a href="#" target="_blank">
                                        ประกาศสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม เรื่อง รายชื่อผู้มีสิทธิเข้ารับการประเมินความเหมาะสมกับตำแหน่งเจ้าพนักงานธุรการปฏิบัติงานสังกัดสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม
                                      </a>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <!-- END panel-->
                </div>
            </div>
        </div>
        <!-- /.row -->

</div>
@endsection

@push('js')
    <script src="{{asset('plugins/components/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('plugins/components/owl.carousel/owl.custom.js')}}"></script>
@endpush
