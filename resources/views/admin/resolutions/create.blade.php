@extends('layouts.admin')


@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Create new Resolution</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/resolutions/') }}" enctype="multipart/form-data" id="resolutionsForm">
                {{ csrf_field() }}
                @if(request()->type === \App\Http\Controllers\Admin\OrdinancesController::RR
                    or request()->type === \App\Http\Controllers\Admin\FormsController::ME)
                    <div class="box-body">
                        <input type="hidden" name="is_monitoring" value={{ request()->type === 'ME' ? 1 : 0 }}>
                        <div class="form-group {{$errors->has('number') ? 'has-error' : ''}}">
                            <label for="number">Number</label>
                            <input name="number" maxlength="5" minlength="1" type="text" class="form-control" id="number" value="{{ old('number') }}">
                            {!! $errors->first('number', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group {{$errors->has('series') ? 'has-error' : ''}}">
                            <label for="series">Series</label>
                            <input name="series" type="text" maxlength="4" minlength="4" class="form-control" id="series" value="{{ old('series')}}">
                            {!! $errors->first('series', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                            <label for="title">Title</label>
                            <textarea class="form-control capitalize" minlength="1" rows="5" name="title" id="title" form="resolutionsForm">{{old('title')}}</textarea>
                            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group {{$errors->has('keywords') ? 'has-error' : ''}}">
                            <label for="keywords">Keywords</label>
                            <textarea class="form-control" maxlength="1000000" minlength="4" rows="5" name="keywords" id="keywords" form="resolutionsForm">{{old('keywords')}}</textarea>
                            {!! $errors->first('keywords', '<p class="help-block">:message</p>') !!}
                        </div>


                            <label for="is_accepting">Comments/Suggestions</label>
                            <div class="checkbox">
                                <label><input name="is_accepting" type="checkbox" value=1>Accept Comments</label>
                            </div>


                        @if(\App\Http\NLPUtilities::isNLPEnabled())
                            <label for="fbpost">Facebook Post</label>
                            <div class="checkbox">
                                <label><input name="fbpost" type="checkbox" value=1>Post to Facebook</label>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="pdf">PDF File</label>
                            <input name="pdf" type="file" class="form-control" id="pdf" accept="application/pdf">
                        </div>
                    </div>
                @endif

                <!-- /.box-body -->

                <div class="box-footer">
                    @if(request()->type === \App\Http\Controllers\Admin\OrdinancesController::RR
                    or request()->type === \App\Http\Controllers\Admin\FormsController::ME
                    or Request::is('*edit*'))
                        <button type="submit" class="pull-right btn btn-primary">Create</button>
                    @endif
                </div>
            </form>
        </div>
        <!-- /.box -->

    </div>
@endsection