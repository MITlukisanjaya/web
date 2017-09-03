@extends('front.layout')

@section('title', 'Article')

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel-heading">
           <div class="panel-title text-center">
                <h1 class="title">Pendaftaran E-Learning</h1>
                <hr />
            </div>
        </div>

        <div class="container">
            <form class="form-horizontal" action="{{ route('auth.post.register') }}" method="post">
            {{ csrf_field() }}
                <div class="form-group row  @isset(session('error')->name) has-danger @endisset">
                  <label for="name" class="col-lg-2 col-sm-12 col-form-label">Nama</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="text" name="name" placeholder="Nama Kamu" id="name" value="{{session('old')['name']}}">
                  @isset (session('error')->name) <p class="form-control-feedback">{{ session('error')->name[0] }}</p> @endisset
                  </div>
                </div>

                <div class="form-group row  @isset(session('error')->username) has-danger @endisset">
                  <label for="username" class="col-lg-2 col-sm-12 col-form-label">Username</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="text" name="username" placeholder="Username Kamu" id="username" value="{{session('old')['username']}}">
                  @isset (session('error')->username) <p class="form-control-feedback">{{ session('error')->username[0] }}</p> @endisset
                  </div>
                </div>

                <div class="form-group row  @isset(session('error')->email) has-danger @endisset">
                  <label for="email" class="col-lg-2 col-sm-12 col-form-label">Email</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="email" placeholder="alamat@email.kamu" id="email" name="email" value="{{session('old')['email']}}">
                  @isset (session('error')->email) <p class="form-control-feedback">{{ session('error')->email[0] }}</p> @endisset
                  </div>
                </div>

                <div class="form-group row  @isset(session('error')->password) has-danger @endisset">
                  <label for="password" class="col-lg-2 col-sm-12 col-form-label">Sandi</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="password" placeholder="sandi kamu" id="password" name="password">
                  @isset (session('error')->password) <p class="form-control-feedback">{{ session('error')->password[0] }}</p> @endisset
                  </div>
                </div>

                <div class="form-group ">
                    <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Daftar</button>
                </div>

                <div class="">
                    <p>Punya akun? <a href="#">Login</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')

@endsection
