@extends('front.layout')
@section('title', 'E-Learning')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="col-md-8 offset-md-2">
	<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#profil" role="tab">Update Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#password" role="tab">Change Password</a>
    </li>
</ul>
<!-- Tab panels -->
<div class="tab-content card">
    <!--Panel 1-->
    <div class="tab-pane active" id="profil" role="tabpanel">
        <br>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{route('front.profile.post.update')}}">
{{ csrf_field() }}
  <div class="form-group row  @isset(session('error')->name) has-danger @endisset">
    <label for="inputName" class="offset-md-1 control-label">Nama</label>
    <div class="col-md-10 offset-md-1">
      <input type="text" class="form-control" id="inputName" name="name" value="{{$user->name}}" placeholder="Nama Lengkap">

     @isset (session('error')->name) <p class="help-block">{{ session('error')->name[0] }}</p> @endisset
    </div>
  </div>

  <div class="form-group row  @isset(session('error')->phone_number) has-danger @endisset">
    <label for="inputPhone" class="offset-md-1 control-label">Telepon</label>
    <div class="col-md-10 offset-md-1">
      <input type="text" class="form-control" id="inputPhone" name="phone_number" value="{{$user->phone_number}}" placeholder="Telepon">
     @isset (session('error')->phone_number) <p class="help-block">{{ session('error')->phone_number[0] }}</p> @endisset
    </div>
  </div> 

  <div class="form-group row  @isset(session('error')->photo) has-danger @endisset">
      <label for="" class="offset-md-1"> Foto</label><br>
      <div class="col-md-10 offset-md-1">

        <div class="col-md-4">
            <img src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/img/avatar.png" alt="" class="img-thumbnail rounded-circle" id="image">
            <input type="file" id="file" name="photo" class="manual-file-chooser height-full width-full ml-0">
     @isset (session('error')->photo) <p class="help-block">{{ session('error')->photo[0] }}</p> @endisset
        </div>
      </div>

  </div>

  <div class="">

    <div class="offset-md-1">
<br>
      <button type="submit" class="btn btn-danger ">Submit</button>

    </div>

  </div>
<br>
<br>
<br>

</form>
    </div>
    <!--/.Panel 1-->
    <!--Panel 2-->
    <div class="tab-pane fade" id="password" role="tabpanel">
        <br>
<form class="form-horizontal" method="post" action="{{route('front.profile.changepassword')}}">
	    {{ csrf_field() }}
	      @if ($errors->any())
	          <div class="alert alert-danger">
	              <ul>
	                  @foreach ($errors->all() as $error)
	                      <li>{{ $error }}</li>
	                  @endforeach
	              </ul>
	          </div>
	      @endif   

	      <div class="form-group row  @isset(session('error')->old_password) has-danger @endisset">
	        <label for="password_lama" class="offset-md-1 control-labell">Password Lama</label>
	        <div class="col-md-10 offset-md-1">
	          <input type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Password Lama">

           @isset (session('error')->old_password) <p class="help-block">{{ session('error')->old_password[0] }}</p> @endisset
	        </div>
	      </div>
	      
	      <div class="form-group row  @isset(session('error')->new_password) has-danger @endisset">
	        <label for="password_baru" class="offset-md-1 control-labell">Password baru</label>
	        <div class="col-md-10 offset-md-1">
	          <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Password Baru">
	           @isset (session('error')->new_password) <p class="help-block">{{ session('error')->new_password[0] }}</p> @endisset
	        </div>
	      </div>

	      <div class="form-group row  @isset(session('error')->confirm_new_password) has-danger @endisset">
	        <label for="verifikasi_password" class="offset-md-1 control-labell">Konfirmasi Password</label>
	        <div class="col-md-10 offset-md-1">
	          <input type="password" class="form-control" id="verifikasi_password" name="verifikasi_password" placeholder="Konfirmasi Password">

          @isset (session('error')->confirm_new_password) <p class="help-block">{{ session('error')->confirm_new_password[0]}}</p> @endisset
	        </div>
	      </div>
<br>

	      <div class="">
	        <div class="col-md-10 offset-md-1">
	          <button type="submit" class="btn btn-danger">Submit</button>
	        </div>
	      </div>
<br>
<br>
<br>
	    </form>
    </div>
    <!--/.Panel 2-->
</div>
</div>
<!-- Nav tabs -->

             





                      
                        
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js">
</script>
<script>
function activaTab(tab){
   $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};
activaTab('{{session('tab')}}');
</script>
@include('sweet::alert')
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