@extends('layouts.master')

@push('css')
    <style>
        .details-wrapper{
            display: inline-block;
            width: 100%;
        }
        .details-wrapper a{
            margin-bottom: 5px;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h1 class="box-title pull-left"><i class="fa fa-tags"></i> {{$category->title}}</h1>
                    <div class="clearfix"></div>
                    <hr>
                    @if(count($blogs) > 0)
                        @foreach($blogs as $blog)
                            <h2><a href="{{url('blogs/'.$blog->slug)}}">{{$blog->title}}</a></h2>
                            <span class="text-muted">โพสต์เมื่อ {{ HP::DateThai($blog->created_at) }}</span>
                            <p>
                              {!! HP::html_cut($blog->content, 5000) !!}

                              <a class="btn btn-info btn-sm" href="{{ url('blogs/'.$blog->slug) }}">อ่านต่อ...</a>

                            </p>
                            <div class="details-wrapper">
                                <a href="{{url('blogs/author/'.$blog->author->id)}}"><span
                                            class="label label-success">ผู้เขียน : {{ $blog->author->reg_fname.' '.$blog->author->reg_lname }}</span></a>
                                <a href="{{url('blogs/category/'.$blog->category->slug)}}"><span
                                            class="label label-primary">หมวดหมู่ : {{$blog->category->title}}</span></a>
                                <div class="pull-right">
                                    @if(count($blog->tags) > 0)
                                        @foreach($blog->tags as $tag)
                                            <a href="{{url('blogs/tag/'.$tag->slug)}}"><span
                                                        class="label label-warning">{{$tag->name}}</span></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                            </div>

                        @endforeach
                        <div class="text-center">
                            {!! $blogs->links() !!}
                        </div>
                    @else
                        <h1>ไม่พบบทความ</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
