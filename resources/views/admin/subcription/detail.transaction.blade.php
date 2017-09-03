@extends('admin.layout')

@section('title', 'List Transaction')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
    <section class="content-header">
        <h1>Transaction</h1>
        <ol class="breadcrumb">
            <li>
                <a href="">
                    <i class="fa fa-credit-card">
                        Transaction
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
                <th>Email</th>
                <th>Status</th>
                <th>Order Total </th>
                <th>Order Id</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->data as $data)
            <tr>
                <td>{{$email}}</td>
                <td>{{$status}}</td>
                <td>{{$order_total}}</td>
                <td>{{$order_id}}</td>
                <td>
                    <a class="btn btn-success btn-sm" title="Detail" href="{{route('admin.transaction.detail', ['id' => $order_id])}}"> <i class="fa fa-list"></i></a>

                     <a class="btn btn-success btn-sm modalku" title="Detail" href='#modal-id' data-id="3" id="3" data-toggle="modal"> <i class="fa fa-list"></i></a>
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
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <input type="text" id="bookId">
                @isset(session('detail')->email) {{session('detail')->email}} @endisset
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <script>

        $('#flash-overlay-modal').modal();
    </script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).on("click", ".modalku", function () {
             var myBookId = $(this).data('id');
             $(".modal-body #bookId").val( myBookId );
        });
    </script>
    <script type="text/javascript">
        @if(session('detail'))
            $('#modal-id').modal('show');
        @endif
    </script>
@endsection