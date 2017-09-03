@extends('front.layout')
@section('title', 'E-Learning')
@section('css')
    <style media="screen">
        .row{
            margin-bottom: 20px;
        }

        article{
            background-color: #E0E0E0;
            padding: 10px;
            margin-bottom: 10px;
            margin-top: 10px;
        }
        figure img{
            width: 100%;
            height: 100%;
        }
        .glyphicon-folder-open,
        .glyphicon-user,
        .glyphicon-calendar,
        .glyphicon-eye-open,
        .glyphicon-comment{
            padding: 5px;
        }
.carousel-item{
    padding: 20rem
    box-shadow: inset 0 0 20rem rgba(0,0,0,1);
}

    </style>
@endsection

@section('content')
@foreach($article->data as $key => $data)
    <article>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <figure>
                    <img src="{{ $data->thumbnail }}">
                </figure>
            </div>
            <div class="col-sm-6 col-md-8">
                <span class="badge label-default float-right"><i class="glyphicon glyphicon-comment"></i>50</span>
                <h4><a href="{{ route('front.article.detail', ['article' => $data->slug]) }}">{{ $data->title }}</a></h4>

                @foreach ($article->categories[$key]->data as $q => $category)
                    <span class="badge badge-pill badge-default">
                        <a href="{{ route('front.article.by.category', ['article' => $category->category->slug]) }}" style="color: #fff;">{{$category->category->category}}</a>
                    </span>
                  {{--   <label class="text-danger">{{$category->category->category}}</label>,  --}}

                @endforeach
                <hr>
                    
                <p>
                    @php
                        echo substr($data->content,0, 400);
                    @endphp
                </p>
                <a href="{{ route('front.article.detail', ['article' => $data->slug]) }}" class="btn btn-default btn-sm float-right">More ... </a>
                <section>
                    <i class="fa fa-user-o" aria-hidden="true"></i> {{ $data->owner }}
                    <i class="fa fa-calendar"></i> {{ $data->published }}
                    {{-- <i class="fa fa-eye"></i> 10000 --}}
                </section>
            </div>
        </div>
    </article>
@endforeach



<!--  --> 

<!--  -->
<nav aria-label="Page navigation example">
@if (isset($article->meta->pagination))
<?php
$page = $article->meta->pagination;
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
<!--  -->

@endsection

@section('js')
<script type="text/javascript">
$('.carousel').carousel()
</script>
@endsection
