@section('title', 'Article')

@section('css')

@endsection

@section('content')
    <div id="container">
    <div id="content">
      <!-- Icons source http://dribbble.com/shots/913555-Flat-Web-Elements -->
      <div class="notify successbox">
        <h1>Success!</h1>
        <span class="alerticon"><img src="http://s22.postimg.org/i5iji9hv1/check.png" alt="checkmark" /></span>
        <p>Thanks so much for your message. We check e-mail frequently and will try our best to respond to your inquiry.</p>
      </div>
      
      <div class="notify errorbox">
        <h1>Warning!</h1>
        <span class="alerticon"><img src="http://s22.postimg.org/ulf9c0b71/error.png" alt="error" /></span>
        <p>You did not set the proper return e-mail address. Please fill out the fields and then submit the form.</p>
      </div>
      
      
    </div><!-- @end #content -->
  </div><!-- @end #w -->
@endsection

@section('js')

@endsection
