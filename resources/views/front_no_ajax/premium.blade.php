@extends('front.layout')
@section('title', 'E-Learning')

@section('css')
    <style>
        a .card{
            text-decoration: none;
            color: #000;
        }
        a:hover{
             text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">
            @if (Session::has('login'))
            <h3 class="text-center">Nikmati layanan premium kami dengan berlangganan</h3>
           
            @isset ($paket)
                <div class="row">
                @foreach ($paket->data as $key => $val)
                    <div class="col-sm-4" style="margin-top: 20px;">
                        <a href="/premium/register/{{ intval(preg_replace('/[^0-9]+/', '', $val->period), 10) }}">
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="card-title text-center">Premium {{ $val->period }}</h5>
                                    <h4 class="text-center">Hanya {{ $val->price }}</h4>
                                    <p class="card-text text-center">Layanan premium dalam {{ strtolower($val->period)}}</p>
                                </div>
                            </div>
                        </a>    

                </div>
                @endforeach
                </div>  
            @endisset
            @endif
            
            
            
        
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-I5uYgRAOyK7tgDVT"></script>
    <script>
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
        snap.pay($("#pay-button").val());
        });
    </script>
@endsection
