@extends('layouts.admin')


@section('content')

    <ol class="breadcrumb">
        @if($ordinance->is_monitoring == 0)
            <li><a href="/admin/ordinances"><i class="fa fa-book"></i> Research & Records</a></li>
            <li><a href="/admin/ordinances">Ordinances</a></li>
        @else
            <li><a href="/admin/forms/ordinances"><i class="fa fa-bar-chart"></i> Monitoring & Evaluation</a></li>
            <li><a href="/admin/forms/ordinances">Ordinances</a></li>
        @endif
        <li><a href="/admin/ordinances/{{$ordinance->id}}">{{$ordinance->id}}</a></li>
        <li  class="active">Edit</li>
    </ol>
<<div class="row">
        <div class="box box-primary color-palette-box">
            <div class="box-header with-border">
                {{--'number', 'title', 'description', 'authors'--}}
                <h3 class="box-title">Edit ORDINANCE {{ $ordinance->number }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="{{ url("/admin/ordinances/{$ordinance->id}/") }}" id="ordinancesForm" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group {{$errors->has('number') ? 'has-error' : ''}}">
                            <label for="number">Number</label>
                            <input name="number" type="text" class="form-control" id="number"
                                   placeholder="Enter Ordinance Number" value="{{old('number', $ordinance->number)}}">
                            {!! $errors->first('number', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group {{$errors->has('series') ? 'has-error' : ''}}">
                            <label for="series">Series</label>
                            <input name="series" type="text" class="form-control" id=series"
                                   placeholder="Enter Ordinance Series" value="{{old('series', $ordinance->series)}}">
                            {!! $errors->first('series', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                            <label for="title">Title</label>
                            <textarea class="form-control" rows="5" name="title" id="title" form="ordinancesForm">{{old('title', $ordinance->title)}}</textarea>
                            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group {{$errors->has('keywords') ? 'has-error' : ''}}">
                            <label for="keywords">Keywords</label>
                            <textarea class="form-control" rows="5" name="keywords" id="keywords" form="ordinancesForm">{{trim(old('keywords', $ordinance->keywords))}}</textarea>
                            {!! $errors->first('keywords', '<p class="help-block">:message</p>') !!}
                        </div>
                        @if(request()->type === 'ME')
                            <label for="is_accepting">Comments/Suggestions</label>
                            <div class="checkbox">
                                <label><input name="is_accepting" type="checkbox" value=1 @if($ordinance->is_accepting==1) {{"checked"}} @endif>Accept Comments</label>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pdf">
                                {{$ordinance->pdf_file_path == "" ? 'No File Uploaded': ('PDF File: ' . substr($ordinance->pdf_file_path, strrpos( $ordinance->pdf_file_path, '/' ) + 1 ))}}
                            </label>
                                <input name="pdf" type="file" class="form-control" id="pdf" accept="application/pdf">
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="description">Keywords</label>--}}
                        {{--<input name="keywords" type="text" class="form-control" id="description"--}}
                               {{--placeholder="Enter description" value="{{ $ordinance->keywords }}">--}}
                    {{--</div>--}}

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="pull-right btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
</div>
    {{--<div class="col-md-6">--}}
        {{--<iframe src = "/ViewerJS/#../storage/ordinances/{{substr($ordinance->pdf_file_path, strrpos( $ordinance->pdf_file_path, '/' ) + 1 )}}"--}}
                {{--width='100%' height='350' allowfullscreen webkitallowfullscreen></iframe>--}}
    {{--</div>--}}
@endsection