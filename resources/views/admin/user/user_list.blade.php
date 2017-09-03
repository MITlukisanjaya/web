@extends('admin.layout')

@section('title', 'List Users')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
    <section class="content-header">
        <h1>Users</h1>
        <ol class="breadcrumb">
            <li>
                <a href="">
                    <i class="fa fa-youtube-play">
                        Users
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

@include('flash::message')

<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Registered</th>
                <th>Set_Role</th>
                <th>Active</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($user->data as $key => $data)
            <tr>
                <td>{{$data->username}}</td>
                <td>{{$data->email}}</td>
                <td>{{$data->registered}}</td>
                <td>{{$data->role}}</td>
                <td>
                    @if ($data->active == 'true')
                        <label for="" class="text-primary" id="status">Active</label>
                    @else
                        <label for="" class="text-warning" id="status">Not Active</label>
                    @endif
                </td>
                <td class="text-center">
                    <form action="{{route('admin.user.destroy', ['user' => $data->username])}}" method="post">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button class="btn btn-danger btn-sm" title="Delete" onclick="javasciprt: return confirm('Yakin Ingin Hapus ?')"><i class="fa fa-trash"></i></button>
                    </form> 
                </td>
            </tr>
        @endforeach
</tbody>
</table>    
@if (isset($user->meta->pagination))
<?php
$page = $user->meta->pagination;
?>
<p class="pull-left"><br><b>Total Data : {{$page->total}}</b></p>
<ul class="pagination pull-right">
    @if (isset($page->links->previous))
    <li><a href="{{url('/admin/user')}}?page=1">First</a></li>
    <li><a href="{{url('/admin/user')}}?page={{$page->current_page-1}}"><<</a></li>
    @else
    <li class="disabled"><a class="disabled">First</a></li>
    <li class="disabled"><a class="disabled"><<</a></li>
    @endif

<?php $x = $page->total_pages+1; ?>

@for ($i =1; $i<$x; $i++ )
    @if ($page->current_page==$i)
    <li class="active"><a href="">{{$i}}</a></li>
    @else
    <li><a href="{{url('/admin/user')}}?page={{$i}}">{{$i}}</a></li>
    @endif
@endfor

    @if (isset($page->links->next))
    <li><a href="{{url('/admin/user')}}?page={{$page->current_page+1}}">>></a></li>
    <li><a href="{{url('/admin/user')}}?page={{$page->total_pages}}">Last</a></li>
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
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
@endsection