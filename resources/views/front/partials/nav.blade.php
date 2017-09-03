<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<div class="container">
  <a class="navbar-brand" href="{{url('/')}}">Elearning</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mr-auto">
              <li class="nav-item {{ active(['lesson','lesson/']) }}">
                <a class="nav-link" href="{{ route('front.lesson.list') }}">Kursus <span class="sr-only">(current)</span></a>
              </li>

              <li class="nav-item {{ active(['article','article/']) }}">
                <a class="nav-link" href="{{ route('front.article.list') }}">Artikel</a>
              </li>
            
            @if (Session::has('login'))
              <li class="nav-item {{ active(['premium','premium/']) }}">
                <a class="nav-link" href="{{ route('premium') }}">Premium</a>
              </li>
            @endif
            </ul>

            <ul class="navbar-nav ml-auto">
                @if (Session::has('login'))
                  @if (Session::get('login')->data->role == 'user')
                    <li class="nav-item  {{ active(['account','account/*']) }}"><a class="nav-link" href="{{ route('front.profile') }}">Profile</a></li>
                  @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.user.profile') }}">Profile</a></li>
                  @endif
                  <li class="nav-item"><a  class="nav-link" href="{{ route('auth.logout') }}">Sign Out</a></li>
                @else
                  <li class="nav-item"><a class="nav-link" href="{{ route('auth.get.register') }}">Sign Up</a></li>
                  <li class="nav-item"><a  class="nav-link" href="{{ route('auth.get.login') }}">Sign In</a></li>
                @endif
            </ul>
  </div>
</div>
</nav>