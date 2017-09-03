@extends('admin.layout')

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
            /*border: 4px solid #FFF;*/
            box-shadow: 0 1px 2px rgba(0, 0, 0, .5);
        }
    </style>    
@endsection

@section('content')
<section class="content">

      <div class="row">
                  @include('flash::message')
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">      
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{$user->data->photo}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{$user->data->name}}</h3>

              <p class="text-muted text-center">{{$user->data->username}}</p>

              {{-- <a href="#" class="btn btn-primary btn-block"><b>Change Photo</b></a> --}}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#info" data-toggle="tab" aria-expanded="true">Info</a></li>
              <li class=""><a href="#edit" data-toggle="tab" aria-expanded="false">Update Profile</a></li>
              <li class=""><a href="#change_password" data-toggle="tab" aria-expanded="false">Change Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="info">
                  <table class="table">
                    <tr>
                      <td>Name</td><td>{{$user->data->name}}</td>
                    </tr>
                    <tr>
                      <td>Phone Number</td><td>{{$user->data->phone_number}}</td>
                    </tr>
                    <tr>
                      <td>Username</td><td>{{$user->data->username}}</td>
                    </tr>
                    <tr>
                      <td>Email</td><td>{{$user->data->email}}</td>
                    </tr>
                    <tr>
                      <td>Role</td><td>{{$user->data->role}}</td>
                    </tr>
                  </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="edit">

@if(session('old')['name'])
  @php
    $name = session('old')['name'];
  @endphp
@else
  @php
    $name = $user->data->name;
  @endphp
@endif

@if(session('old')['phone_number'])
  @php
    $phone_number = session('old')['phone_number'];
  @endphp
@else
  @php
    $phone_number = $user->data->phone_number;
  @endphp
@endif

                <form class="form-horizontal" action="{{route('admin.user.updateprofile')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                  <div class="form-group @isset(session('error')->name) has-error @endisset">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{$name}}" name="name">
                      @isset (session('error')->name) <p class="help-block">{{ session('error')->name[0] }}</p> @endisset
                    </div>
                  </div>
                  <div class="form-group @isset(session('error')->phone_number) has-error @endisset">
                    <label for="phone_number" class="col-sm-2 control-label">No. HP</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="phone_number" placeholder="No. HP" value="{{$phone_number}}" name="phone_number">
                      @isset (session('error')->phone_number) <p class="help-block">{{ session('error')->phone_number[0] }}</p> @endisset
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email" disabled="" value="{{$user->data->email}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputUsername" placeholder="Username" disabled="" value="{{$user->data->username}}">
                    </div>
                  </div>     
                  <div class="form-group @isset(session('error')->photo) has-error @endisset">
                      <label for="" class="col-sm-2 control-label"> Foto</label><br>
                      <div class="col-sm-10">
                      <div class="col-sm-4">
                          <img src="{{$user->data->photo}}" alt="" class="image_preview" id="image">
                          <label class="button-change-avatar mt-3 position-relative width-full btn btn-default">
                              Upload Foto
                              <input type="file" id="file" name="photo" class="manual-file-chooser height-full width-full ml-0">
                          </label>

                      </div>
                      @isset (session('error')->photo) <p class="help-block">{{ session('error')->photo[0] }}</p> @endisset
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="change_password">
                <form class="form-horizontal" action="{{route('admin.user.changepassword')}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                  <div class="form-group @isset(session('error')->old_password) has-error @endisset">
                    <label for="password_lama" class="col-sm-2 control-label">Password Lama</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password_lama" placeholder="Password Lama" name="old_password">
                      @isset (session('error')->old_password) <p class="help-block">{{ session('error')->old_password[0] }}</p> @endisset
                    </div>
                  </div>
                  <div class="form-group @isset(session('error')->new_password) has-error @endisset">
                    <label for="password_baru" class="col-sm-2 control-label">Password baru</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password_baru" placeholder="Password Baru" name="new_password">
                      @isset (session('error')->new_password) <p class="help-block">{{ session('error')->new_password[0] }}</p> @endisset
                    </div>
                    
                  </div>
                  <div class="form-group @isset(session('error')->confirm_new_password) has-error @endisset">
                    <label for="konfirmasi_password" class="col-sm-2 control-label">Konfirmasi Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="konfirmasi_password" placeholder="Konfirmasi Password" name="confirm_new_password">
                      @isset (session('error')->confirm_new_password) <p class="help-block">{{ session('error')->confirm_new_password[0] }}</p> @endisset
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>


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
            }             z
        });
    });
    function imageIsLoaded(e) {
        $('#image').attr('src', e.target.result);
    };
});

function activaTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};

activaTab('{{session('tab')}}');

</script>
@endsection