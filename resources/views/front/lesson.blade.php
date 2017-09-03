@extends('front.layout')
@section('title', 'Lesson')

@section('css')
<style>

</style>
@endsection

@section('content')

<!-- start carousel -->
    <div id="carousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <?php $max = count($slide); ?>
        @for ($i = 0; $i < $max; $i++)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
        @endfor

        
      </ol>
      <div class="carousel-inner" role="listbox">
        @foreach ($slide as $key => $val)
            @if ($key == 0)
                <div class="carousel-item active">
            @else
                <div class="carousel-item">
            @endif
              <img class="d-block img-fluid col-12" src="{{url($val->thumbnail)}}" alt="First slide">
              <div class="carousel-caption d-none d-md-block">
                <h3>{{$val->title}}</h3>
                <p>{!! substr($val->summary,0, 100) !!}</p>
             </div>
             </div>
        @endforeach

       <!--  <ol class="carousel-indicators">
            <li data-target="#carousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel" data-slide-to="1"></li>
            <li data-target="#carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          @foreach ($slide as $key => $val)
            <div class="carousel-item">
                <img class="d-block img-fluid" src="{{url($val->thumbnail)}}" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                  <h3>{{$val->title}}</h3>
                  <p>{{$val->summary}}</p>
                </div>
            </div>
          @endforeach
            -->
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
<!-- end carousel -->

<!-- start row item card <-->
<div class="row">

@foreach ($lesson->data as $val) 
     
       <div class="col-sm-6 col-md-4" style="margin-top:20px;">
            <div class="card">

              <img class="img img-thumbnail card-img-top" src="{{$val->thumbnail}}" alt="Card image cap">
              <div class="card-block" style="height: 5px">
                 @foreach ($val->categories as $q => $category)
                        <span class="badge badge-pill badge-default">
                            <a href="{{ route('front.lesson.by.category', ['article' => $category->category->slug]) }}" style="color: #fff;">{{$category->category->category}}</a>
                        </span> 
                @endforeach
              </div>
              <div class="card-block" style="height: 250px">
                <h5 class="card-title">{{ $val->title }}</h5>
              
                <p class="card-text text-justify" style="min-height: 400px;max-height: 400px;">
                  {!!substr($val->summary,0, 100)!!}
                </p>
              </div>
             
              <a href="{{ route('front.lesson.detail', ['slug' => $val->slug]) }}" class="btn btn-primary">Details</a>
            </div>
        </div>

@endforeach
</div>


<!--start pagination-->
    <nav aria-label="Page navigation example" style="margin-top: 10px;">


@if (isset($lesson->meta->pagination))
<?php
$page = $lesson->meta->pagination;
?>
<p class="pull-left"><br><b>Total Data : {{$page->total}}</b></p>
<ul class="pagination justify-content-end">
    @if (isset($page->links->previous))
    <li class="page-item"><a class="page-link" href="{{url('/lesson')}}?page=1">First</a></li>
    <li class="page-item">
      <a class="page-link" href="{{url('/lesson')}}?page={{$page->current_page-1}}" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Previous</span>
      </a>
    </li>
    @else
    <li class="page-item"><a class="page-link disabled">First</a></li>
    <li class="page-item">
      <a class="page-link disabled" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Previous</span>
      </a>
    </li>
    @endif

<?php $x = $page->total_pages; ?>

@for ($i =1; $i<=$x; $i++ )
    @if ($page->current_page==$i)
    <li class="page-item active"><a class="page-link" href="">{{$i}}</a></li>
    @else
    <li class="page-item"><a class="page-link" href="{{url('/lesson')}}?page={{$i}}">{{$i}}</a></li>
    @endif
@endfor

    @if (isset($page->links->next))
    <li class="page-item">
      <a class="page-link" href="{{url('/lesson')}}?page={{$page->current_page+1}}" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
    <li class="page-item"><a href="{{url('/lesson')}}?page={{$page->total_pages}}">Last</a></li>
    @else
     <li class="page-item">
      <a class="page-link disabled" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link disabled">Last</a></li>
    @endif
</ul>                    
@endif


    </nav>
<!--end pagination-->


@endsection

@section('js')
    <script type="text/javascript">
        $('#carousel').carousel()
    </script>
@endsection
