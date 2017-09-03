@extends('admin.layout')

@section('title', 'List Lessons')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
    <section class="content-header">
        <h1>Draft Lessons</h1>
        <ol class="breadcrumb">
            <li>
                <a href="">
                    <i class="fa fa-youtube-play">
                        Lessons
                    </i>
                </a>
            </li>
            <li class="active"> Draft </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">

@include('flash::message')
<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Category</th>
                <th>Creator</th>
                <th>Type</th>
                <th>Status</th>
                <th>Published_at</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($lesson->data as $q => $data)
            <tr>
                <td class="text-center"><img src="{{$data->thumbnail}}" alt="" width="200px" height="200px"></td>
                <td>{{$data->title}}</td>
                <td>
                        @foreach ($lesson->categories[$q]->data as $data_category)
                            <label class="text-danger">{{$data_category->category->category}}</label>,
                        @endforeach
                </td>
                <td>{{$data->owner}}</td>
                <td>
                    @if ($data->type == 'free')
                        <label for="" class="text-primary" id="status">Free</label>
                    @else
                        <label for="" class="text-warning" id="status">Premium</label>
                    @endif
                </td>
                <td>
                    @if ($data->status == 'publish')
                        <label for="" class="text-primary" id="status">Publish</label>
                    @else
                        <label for="" class="text-warning" id="status">Draft</label>
                    @endif
                </td>
                <td>{{$data->published}}</td>
                <td class="text-center">
                    <a href="{{url('/admin/lesson')}}/{{$data->slug}}/part" class="btn btn-success btn-sm" title="Lesson"> <i class="fa fa-youtube-play"></i></a>
                    <a href="{{url('/admin/lesson')}}/{{$data->slug}}" class="btn btn-primary btn-sm" title="Edit"> <i class="fa fa-pencil"></i></a>
                    <form action="{{route('admin.lesson.destroy', ['slug' => $data->slug])}}" method="post">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
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
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <script>

        $('#flash-overlay-modal').modal();
    </script>
@endsection
