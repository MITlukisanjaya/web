@extends('admin.layout')

@section('title', 'Form Lessons')

@section('css')
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/select2/dist/css/select2.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/awesome-bootstrap-checkbox/0.3.7/awesome-bootstrap-checkbox.min.css" rel="stylesheet">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3c8dbc;
            border-color: #367fa9;
            color: #fff;
        }
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
            border: 4px solid #FFF;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .5);
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1>Lessons</h1>
        <ol class="breadcrumb">
            <li>
                <a href="">
                    <i class="fa fa-youtube-play">
                        Lessons
                    </i>
                </a>
            </li>
            <li class="active"> @if(isset($lesson->data)) Edit @else Add @endif  </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">

@if(session('old')['title'])
  @php
    $title = session('old')['title'];
  @endphp
@else
  @php
    if (isset($lesson->data->title)) {
        $title = $lesson->data->title;
    }else {
        $title = "";
    }
  @endphp
@endif

@if(session('old')['summary'])
  @php
    $summary = session('old')['summary'];
  @endphp
@else
  @php
    if (isset($lesson->data->summary)) {
        $summary = $lesson->data->summary;
    }else {
        $summary = "";
    }
  @endphp
@endif

@if(session('old')['url_source_code'])
  @php
    $url_source_code = session('old')['url_source_code'];
  @endphp
@else
  @php
    if (isset($lesson->data->url_source_code)) {
        $url_source_code = $lesson->data->url_source_code;
    }else {
        $url_source_code = "";
    }
  @endphp
@endif

@if(session('old')['type'])
  @php
    $type = session('old')['type'];
  @endphp
@else
  @php
    if (isset($lesson->data->type)) {
        $type = $lesson->data->type;
    }else {
        $type = "";
    }
  @endphp
@endif

@if(session('old')['status'])
  @php
    $status = session('old')['status'];
  @endphp
@else
  @php
    if (isset($lesson->data->status)) {
        $status = $lesson->data->status;
    }else {
        $status = "publish";
    }
  @endphp
@endif
@if(isset($lesson->data))
    @include('admin.lesson.edit_lesson')
@else
    @include('admin.lesson.create_lesson')
@endif
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="form-group @isset(session('error')->title) has-error @endisset">
                                <label for=""> Title</label>
                                <input id='title' type='text' name='title' required value='{{ $title }}' class='form-control'>
                                @isset (session('error')->title) <p class="help-block">{{ session('error')->title[0] }}</p> @endisset
                            </div>
                            <div class="form-group @isset(session('error')->summary) has-error @endisset">
                                <label for=""> Summary</label>
                                <textarea name="summary" id="summary" cols="30" rows="10" class="form-control">
                                    {{ $summary }}
                                </textarea>
                                @isset (session('error')->summary) <p class="help-block">{{ session('error')->summary[0] }}</p> @endisset
                            </div>
                            <div class="form-group @isset(session('error')->category) has-error @endisset">
                                <label for=""> Category</label>
                                <select class="select2 form-control" multiple="multiple" name="categories[]">
                                  @isset($categories->data)
                                      @foreach ($categories->data as $val)
                                          <option value="{{ $val->category->slug }}" selected="selected">
                                              {{ $val->category->category }}
                                          </option>
                                      @endforeach
                                  @endisset
                                  @if(session('old')['categories'])
                                      @foreach (session('old')['categories'] as $val)
                                          <option value="{{ $val }}" selected="selected">
                                              {{ $val }}
                                          </option>
                                      @endforeach
                                  @endif
                                  @foreach ($category->data as $data)
                                      <option value="{{$data->slug}}">
                                          {{$data->category}}
                                      </option>
                                  @endforeach
                                </select>
                                @isset (session('error')->category) <p class="help-block">{{ session('error')->category[0] }}</p> @endisset
                            </div>
                            <div class="form-group @isset(session('error')->url_source_code) has-error @endisset">
                                <label for=""> URL Source Code</label>
                                <input id='title' type='text' name='url_source_code' required value='{{ $url_source_code }}' class='form-control'>
                                @isset (session('error')->url_source_code) <p class="help-block">{{ session('error')->url_source_code[0] }}</p> @endisset
                            </div>
                            <div class="form-group @isset(session('error')->type) has-error @endisset">
                                <label for=""> Type</label><br>
                                @php
                                     $free = 'checked="checked"';
                                     $premium   = '';
                                @endphp
                                 @isset($lesson)
                                     @php
                                         if ($lesson->data->type == 'free') :
                                             $free = 'checked="checked"';
                                             $premium   = '';
                                         else :
                                             $free = '';
                                             $premium   = 'checked="checked"';
                                         endif;
                                     @endphp
                                 @endisset
                                <div class="radio radio-primary radio-inline">
                                    <input type="radio" name="type" value="0" {{ $free }} class="form-control">
                                    <label>
                                        Free
                                    </label>
                                </div>
                                <div class="radio radio-warning radio-inline">
                                    <input type="radio" name="type" value="1" {{ $premium }} class="form-control">
                                    <label>
                                        Premium
                                    </label>
                                </div>
                                @isset (session('error')->type) <p class="help-block">{{ session('error')->type[0] }}</p> @endisset
                            </div>
                            <div class="form-group @isset(session('error')->status) has-error @endisset">
                                <label for=""> Status</label><br>
                                @php
                                     $publish = 'checked="checked"';
                                     $draft   = '';
                                @endphp
                                 @isset($lesson->data->status)
                                     @php
                                         if ($lesson->data->status == 'publish') :
                                             $publish = 'checked="checked"';
                                             $draft   = '';
                                         else :
                                             $publish = '';
                                             $draft   = 'checked="checked"';
                                         endif;
                                     @endphp
                                 @endisset
                                 <div class="radio radio-primary radio-inline">
                                     <input type="radio" name="status" value="1" {{ $publish }} class="form-control">
                                     <label>
                                         Publish
                                     </label>
                                 </div>
                                 <div class="radio radio-warning radio-inline">
                                     <input type="radio" name="status" value="0" {{ $draft }} class="form-control">
                                     <label>
                                         Draft
                                     </label>
                                 </div>
                                @isset (session('error')->status) <p class="help-block">{{ session('error')->status[0] }}</p> @endisset
                            </div>
                            <div class="form-group @isset(session('error')->thumbnail) has-error @endisset">
                                <label for=""> Thumbnail</label><br>
                                <div class="col-md-3">
                                    @php
                                        $img = 'https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/img/avatar.png';
                                    @endphp
                                    @isset($lesson->data->thumbnail)
                                        @php
                                            $img = $lesson->data->thumbnail;
                                        @endphp
                                    @endisset

                                    <img src="{{ $img }}" alt="" class="image_preview" id="image">
                                    <label class="button-change-avatar mt-3 position-relative width-full btn btn-default">
                                        Upload Thumbnail
                                        <input type="file" id="file" name="thumbnail" class="manual-file-chooser height-full width-full ml-0"
                                        value="@isset($img) {{ $img }} @endisset">
                                    </label>

                                </div>
                                @isset (session('error')->thumbnail) <p class="help-block">{{ session('error')->thumbnail[0] }}</p> @endisset
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-left">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script src="https://adminlte.io/themes/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $(".select2").select2();
    $('#summary').wysihtml5()
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
            }
        });
    });
    function imageIsLoaded(e) {
        $('#image').attr('src', e.target.result);
    };
});
</script>
@endsection
