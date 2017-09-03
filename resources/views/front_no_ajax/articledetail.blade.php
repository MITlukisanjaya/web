@extends('front.layout')
@section('title', 'E-Learning')

@section('css')
@endsection

@section('content')
<div class="container">
    <div class="card card-block" style="margin-top: 30px;"> 
        <div class="row">
             <div class="col-md-12">
                 <!-- <div class="row hidden-md hidden-lg"><h1 class="text-center" >TITULO LARGO DE UNA INVESTIGACION cualquiera</h1></div> -->
                     
                <!--  <div class="pull-left col-md-4 col-xs-12 thumb-contenido"><img class="center-block img-responsive" src='http://placehold.it/500x500' /></div> -->
                <div class="">
                    <small class="">{{ $article->data->published }}</small><br>
                     <h1  class="hidden-xs hidden-sm">{{ $article->data->title }}</h1>
                     <small class="col-2"><strong>{{ ucfirst($article->data->owner) }}</strong></small>
                     <hr>
                     <!-- <div class="container"> -->
                        
                       
                        @foreach ($article->categories->data as $q => $category)
                            <span class="badge badge-pill badge-default">
                            <a href="{{ route('front.article.by.category', ['article' => $category->category->slug]) }}" style="color: #fff;">{{$category->category->category}}</a>
                            </span> 

                        @endforeach

                     <!-- </div> -->
                     @if ($article->categories->data)
                        <hr>
                     @endif
                     <img class="img-fluid" src="{{ $article->data->thumbnail }}" alt="default.jpg" style="max-width: 100%;">
                     <div class="clearfix"></div><br>

                     <p class="text-justify">
                         {!! $article->data->content !!}
                     </p>
             </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
