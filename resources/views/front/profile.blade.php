@extends('front.layout')



@section('title', 'Info Profile')



@section('css')

    <style>
        .position-relative {
            position: relative !important;
        }

        .manual-file-chooser {
            position: absolute;
            width: 240px;
            padding: 5px;
            top: 0;
            left: 0;
            margin-left: -80px;
            opacity: 0.0001;
        }

        .width-full {
            width: 100% !important;
        }

        .height-full {
            height: 100% !important;
        }

        .ml-0 {
            margin-left: 0 !important;
        }

        .mt-3 {
            margin-top: 16px !important;
        }

        .image_preview{
            display: inline-block;
            width: 100%;
            height: 220px;
            border-radius: 5%;
            background-repeat: no-repeat;
            border: 4px solid #FFF;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .5);
        }

    </style>    

@endsection



@section('content')

<section class="content">

    <div class="row justify-content-center">
    <div class="card col-md-8">
        
<h4 class="card-header">Profile</h4>     
            <div class="row">

                <div class="col-md-4">

<!-- Profile Image -->

                    <div class="box box-primary">
                        <div class="box-body box-profile">
                          <img class="img-fluid rounded-circle" src="{{ $profil->photo }}" alt="User profile picture">
                        </div>
<!-- /.box-body -->
                    </div>
<!-- /.box -->
              </div>

        <!-- /.col -->

                <div class="col-md-8">
                    <ul>
                      <h3>{{ $profil->name }}<br>
                      <small>Type Account : {{ $profil->role }}</small></h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-envelope user-profile-icon"></i> {{ $profil->email }}
                        </li>

                        <li>
                          <i class="fa fa-phone user-profile-icon"></i> {{ $profil->phone_number }}
                        </li>

                        <li>
                          <a href="{{route('front.profile.update')}}" class="btn btn-default">
                          <i class="fa fa-edit user-profile-icon"></i> Edit Profil</a>
                        </li>
                      </ul>
                    </ul>
                   



                </div>

   
<div class="col-md-12">
<br>
<hr> 
    <h5 class="text-center">Riwayat Transaksi</h5> 

<table class="table table-hover">
  <thead>
    <tr>
      <th>No.</th>
      <!-- <th>Tanggal Order</th> -->
      <th>Order ID</th>
      <th>Order Total</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 1;?>
    @foreach ($transaksi as $key => $val)
        <tr>
          <th scope="row">{{$i++}}</th>
          <td>{{$val->order_id}}</td>
          <td>{{$val->order_total}}</td>
          <td>{{$val->status}}</td>
        </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>

                  </div>

                </div>


    

</section>    


<!--  -->
               

@endsection



@section('js')

<script>

$(document).ready(function (e) {
    $(function() {
        $("#file").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg", "image/gif"];

            if((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3])) {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }

        });

        $(function () {
            $('#tab-profile a:last').tab('show')
        })

    });

    function imageIsLoaded(e) {
        $('#image').attr('src', e.target.result);
    };

});

</script>

@endsection