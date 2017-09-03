@extends('front.layout')
@section('title', 'E-Learning')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.3/mediaelementplayer.min.css" rel="stylesheet">

<style>
    .lesson-part:hover{
        text-decoration: none;
    }
    .hitam{
        color: #000;
    }

    .mejs__overlay-button {
    background-image: url("/path/to/mejs-controls.svg");
    }
    .mejs__overlay-loading-bg-img {
        background-image: url("/path/to/mejs-controls.svg");
    }
    .mejs__button > button {
        background-image: url("/path/to/mejs-controls.svg");
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="card card-block" style="margin-top: 30px;"> 
        <div class="row">
                <div class="col-lg-12">
                     <h1  class="hidden-xs hidden-sm">{{ $lesson->data->title }}</h1>
                     <small class="col-lg-3 col-sm-12"><strong>{{ ucfirst($lesson->data->owner) }}</strong></small>
                     <hr>                

                        @foreach ($lesson->category->data as $q => $category)
                            <span class="badge badge-pill badge-default">
                                <a href="{{ route('front.lesson.by.category', ['article' => $category->category->slug]) }}" style="color: #fff;">{{$category->category->category}}</a>
                            </span> 

                        @endforeach

                     @if ($lesson->category->data)
                        <hr>
                     @endif
                </div>
                <div class="col-lg-9 col-sm-12">
                            <h3>{{ $video->data->title }}</h3>
                            <p >
                            

{{-- <video class="video-js vjs-default-skin col-lg-12" controls autoplay
    data-setup='{ "techOrder": ["youtube", "html5"], "sources": [{ "type": "video/youtube", "src": "{{ $video->data->url_video }}"}] }'>
</video> --}}
<video src="{{$video->data->url_video}}" class="mejs__player" style="width:100%;height:100%;" controls="controls" class="col-sm-12 col-lg-12" 
 preload="auto"></video>
                            </p>
                            <hr>
                            <h3>Lesson Part</h3>
                          
                            @isset ($part->data)
                                @php
                                    $i = 1;
                                @endphp
                                    @foreach ($part->data as $val)
                                        <ul class="list-group">
                                            <a href="{{ route('front.lesson.video',['slug' => $val->slug, 'parent' => $lesson->data->slug]) }}" class="lesson-part">
                                                <li class="list-group-item hitam">
                                                    {{ $i++ }} &nbsp;&nbsp;&nbsp;
                                                    <i class="fa fa-film"  > </i> 
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span class="hitam">{{ $val->title }}</span>
                                                    &nbsp;&nbsp;&nbsp; 
                                                    <span class="badge badge-pill badge-primary" style="color: #fff;">Video</span>
                                                </li>
                                            </a>
                                    @endforeach
                            @endisset

                            @isset ($part->error)
                                <p>{{ $part->error->message }}</p>
                            @endisset


                </div>

                         <div class="col-lg-3 col-sm-12">
                             <div class="card card-block">
                                 <h5 class="text-center">{{ ucfirst($lesson->data->type) }}</h5>
                                 <hr>
                                 <p>Kategori: {{$category->category->category}}</p>
                                 <p>Jumlah Kursus: {{count($part->data)}} bagian</p>
                                 <p>Diterbitkan: 12 Juli 2016</p>
                             </div>
                         </div>
             </div>
        </div>
    </div>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.3/mediaelement-and-player.min.js"></script>

<script>
    $(document).ready(function(){$('video, audio').mediaelementplayer();});

</script>
</script>
@endsection