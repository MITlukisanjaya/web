<!DOCTYPE html>
<html>
    <head>
        <title>Masuk Elearning</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <style media="screen">
            body, html{
                 height: 100%;
                background-repeat: no-repeat;
                background-color: #d3d3d3;
                font-family: 'Oxygen', sans-serif;
                }
            .main {
                background-color: #fff;
                /* shadows and rounded borders */
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
                border-radius: 2px;
                -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            }
            .main-center{
                margin-top: 30px;
                margin: 0 auto;
                /*max-width: 50%;*/
                padding: 40px 40px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="panel-heading">
                   <div class="panel-title text-center">
                      <h1 class="title">Masuk E-Learning</h1>
                      <hr />
                    </div>
                </div>



                <div class="main main-center">
                   

                    <form class="form-horizontal" action="{{ route('auth.post.login') }}" method="post">
{{ csrf_field() }}
                        <div class="form-group row  @isset(session('error')->name) has-danger @endisset"">
                          <label for="username" class="col-2 col-sm-12 col-form-label">Username</label>
                          <div class="col-10 col-sm-12">
                            <input class="form-control" type="text" placeholder="username" id="username" name="username" value="{{session('old')['username']}}">
                          @isset (session('error')->username) <p class="form-control-feedback">{{ session('error')->username[0] }}</p> @endisset
                          </div>
                        </div>

                        <div class="form-group row  @isset(session('error')->password) has-danger @endisset"">
                          <label for="password" class="col-2 10 col-sm-12 col-form-label">Sandi</label>
                          <div class="col-10 10 col-sm-12">
                            <input class="form-control" type="password" placeholder="sandi kamu" id="password" name="password">
                  @isset (session('error')->password) <p class="form-control-feedback">{{ session('error')->password[0] }}</p> @endisset
                          </div>
                        </div>

                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Masuk</button>
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <p><a href="#">Lupa sandi</a></p>
                            </div>
                            <div class="col-4 float-right">
                                <p><a href="{{ route('auth.get.register') }}">Daftar</a></p>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </body>
@include('front.partials.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js">
</script>
@include('sweet::alert')
</html>