@extends('admin.layout')

@section('title', 'List Lessons')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">    
@endsection

@section('content')
    <section class="content-header">
        <h1>Lessons Part - <small>{{$lessonPart->sluglesson}}</small></h1>
        <ol class="breadcrumb">
            <li>
                <a href="">
                    <i class="fa fa-youtube-play">
                        Part Lessons
                    </i>
                </a>
            </li>
            <li class="active"> List </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
<div>
    <a data-toggle="modal" class="btn btn-sm btn-info" data-target="#myModal">Add Part Lessons</a>
    <br><br>
</div>

@include('flash::message')

<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Title</th>
                <th>Url_Video</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
       @foreach ($lessonPart->data as $q => $data)
            <tr>
                <td>{{$data->title}}</td>
                <td>{{$data->url_video}}</td>

                <td class="text-center">
                    <a href="{{url('/admin/lesson')}}/{{$lessonPart->sluglesson}}/{{$data->slug}}/show" class="btn btn-primary btn-sm" title="Edit"> <i class="fa fa-pencil"></i></a>
                    <form action="{{url('/admin/lesson')}}/{{$lessonPart->sluglesson}}/{{$data->slug}}" method="post">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-danger btn-sm" title="Delete" onclick="javasciprt: return confirm('Yakin Ingin Hapus ?')"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
</tbody>
</table>
                    </div>
                </div>
            </div>
        </div>
    </section>                
@endsection

@section('js')
    <script src="https://adminlte.io/themes/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script type="text/javascript">
        $('#summary').wysihtml5()
    </script>
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    <script type="text/javascript">
    @if(session('error'))
        $('#myModal').modal('show');
    @endif
    @if(session('lessonPartEdit'))
        $('#myModal').modal('show');
    @endif
    </script>
@endsection
<!-- Modal -->
@if(session('old')['title'])
  @php
    $title = session('old')['title'];
  @endphp
@else
  @php
    if (isset(session('lessonPartEdit')->title)) {
        $title = session('lessonPartEdit')->title;
    }else {
        $title = "";
    }
  @endphp
@endif

@if(session('old')['url_video'])
  @php
    $url_video = session('old')['url_video'];
  @endphp
@else
  @php
    if (isset(session('lessonPartEdit')->url_video)) {
        $url_video = session('lessonPartEdit')->url_video;
    }else {
        $url_video = "";
    }
  @endphp
@endif
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Lesson</h4>
      </div>
      <div class="modal-body">

            @if(session('lessonPartEdit'))
            <form action="{{route('admin.lessonpart.update', ['slug' => $lessonPart->sluglesson, 'slugPart' => session('lessonPartEdit')->slug])}}" method="POST">
            @else
            <form action="{{route('admin.lessonpart.store', ['slug' => $lessonPart->sluglesson])}}" method="POST">
            @endif
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="form-group @isset(session('error')->title) has-error @endisset">
                                <label for=""> Title</label>
                                <input id='title' type='text' name='title' required value='{{$title}}' class='form-control'>
                                @isset (session('error')->title) <p class="help-block">{{ session('error')->title[0] }}</p> @endisset
                            </div>
                            <div class="form-group @isset(session('error')->url_video) has-error @endisset">
                                <label for=""> Url Video</label>
                                <input id='url_Video' type='text' name='url_video' required value='{{$url_video}}' class='form-control'>
                                @isset (session('error')->url_video) <p class="help-block">{{ session('error')->url_video[0] }}</p> @endisset
                            </div>                            
                        </div>
                        <div class="box-footer">
                            <div class="pull-left">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit</button>
                            </div>
                        </div>
                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
