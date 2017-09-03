@extends('front.layout')
@section('title', 'E-Learning')

@section('css')

@endsection

@section('content')


		
@endsection

@section('js')
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-I5uYgRAOyK7tgDVT"></script>
		<script>

		$(document).ready(function() {

		  snap.pay("{{$body['token']}}");

		});

		</script>
@endsection


 <!-- <!DOCTYPE html>

<html>

<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>



<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-I5uYgRAOyK7tgDVT"></script>

<script>

$(document).ready(function() {

  snap.pay("d127eed5-1cbb-428f-ae06-6ffc28e86ec2");

});

</script>

</body>

</html> -->