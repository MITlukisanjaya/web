@extends('admin.layout')

@section('title', 'List Articles')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
    <section class="content-header">
        <h1>Articles</h1>
        <ol class="breadcrumb">
            <li>
                <a href="">
                    <i class="fa fa-pencil-square-o">
                        Articles
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
                <th>Status</th>
                <th>Published_at</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($article->data as $key => $data)
            <tr>
                <td class="text-center"><img src="{{$data->thumbnail}}" alt="" width="200px" height="200px"></td>
                <td>{{$data->title}}</td>
                <td>
                    @foreach ($article->categories[$key]->data as $q => $category)
                        <label class="text-danger">{{$category->category->category}}</label>,
                    @endforeach
                </td>
                <td>{{$data->owner}}</td>
                <td>
                    @if ($data->status == 'publish')
                        <label for="" class="text-primary" id="status">Publish</label>
                    @else
                        <label for="" class="text-warning" id="status">Draft</label>
                    @endif
                </td>
                <td>{{$data->published}}</td>
                <td class="text-center">
                    <a href="{{url('/admin/article')}}/{{$data->slug}}" class="btn btn-primary btn-sm" title="Edit"> <i class="fa fa-pencil"></i></a>

                    <form action="{{route('admin.article.destroy', ['slug' => $data->slug])}}" method="post">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-danger btn-sm" title="Delete" onclick="javasciprt: return confirm('Yakin Ingin Hapus ?')"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
</tbody>
</table>
@if (isset($article->meta->pagination))
<?php
$page = $article->meta->pagination;
?>
<p class="pull-left"><br><b>Total Data : {{$page->total}}</b></p>
<ul class="pagination pull-right">
    @if (isset($page->links->previous))
    <li><a href="{{url('/admin/article')}}?page=1">First</a></li>
    <li><a href="{{url('/admin/article')}}?page={{$page->current_page-1}}"><<</a></li>
    @else
    <li class="disabled"><a class="disabled">First</a></li>
    <li class="disabled"><a class="disabled"><<</a></li>
    @endif

<?php $x = $page->total_pages+1; ?>

@for ($i =1; $i<$x; $i++ )
    @if ($page->current_page==$i)
    <li class="active"><a href="">{{$i}}</a></li>
    @else
    <li><a href="{{url('/admin/article')}}?page={{$i}}">{{$i}}</a></li>
    @endif
@endfor

    @if (isset($page->links->next))
    <li><a href="{{url('/admin/article')}}?page={{$page->current_page+1}}">>></a></li>
    <li><a href="{{url('/admin/article')}}?page={{$page->total_pages}}">Last</a></li>
    @else
    <li class="disabled"><a>>></a></li>
    <li class="disabled"><a class="disabled">Last</a></li>
    @endif
</ul>
@endif
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
