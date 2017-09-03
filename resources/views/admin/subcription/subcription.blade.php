@extends('admin.layout')

@section('title', 'List Subcription')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
    <section class="content-header">
        <h1>Subcription</h1>
        <ol class="breadcrumb">
            <li>
                <a href="">
                    <i class="fa fa-usd">
                        Subcription
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
                @foreach ($subcription->data as $key => $data)
                <th>{{$data->period}}</th>
                @endforeach
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <form action="{{route('admin.subcription.index')}}" method="post">
                @foreach ($subcription->data as $key => $data)
                @php
                    $name = explode(' Bulan', $data->period);
                @endphp
                <td><input type="text" value="{{$data->price}}" name="month{{$name[0]}}">
                </td>
                @endforeach
                <td class="text-center">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <button class="btn btn-danger btn-sm" title="Update Harga" onclick="javasciprt: return confirm('Yakin Ingin Update Harga ?')"><i class="fa fa-send"></i></button>
                </td>
                </form>
            </tr>
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
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
@endsection