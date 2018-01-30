@extends('layouts.admin')

@section('content')
    @if($resolution->is_monitoring === 1)
        {{-- IS in M&E --}}
        <div class="col-xs-12">

            @if($questionnaire)
                {{--It has a questionnaire--}}

                <div class="box box-default color-palette-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-file-text"></i> Questionnaire</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <div class="pull-right">
                                @if($questionnaire->isAccepting == 0)
                                    <form style="display: inline;" method="post"
                                          action="{{ url('/admin/acceptResponses/' . $questionnaire->id) }}">
                                        {{ csrf_field() }}
                                        <button class="btn btn-success">
                                            <span class="fa fa-comments-o"></span> Accept Responses
                                        </button>
                                    </form>
                                @else
                                    <form style="display: inline;" method="post"
                                          action="{{ url('/admin/declineResponses/' . $questionnaire->id) }}">
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger">

                                            <span class="fa fa-times"></span> Decline Responses
                                        </button>
                                    </form>
                                @endif
                                <a href="{{"/admin/result/{$questionnaire->id}"}}"
                                   class="btn btn-success"><span class="fa fa-th-list"></span> Results</a>
                                <a href="{{"/admin/forms/{$questionnaire->id}"}}" class="btn btn-info"><span><span
                                                class="fa fa-eye"></span> Preview</span></a>
                                <a href="{{ url("/admin/forms/{$questionnaire->id}/edit") }}"
                                   class="btn  btn-warning"><span class="fa fa-edit"></span> Edit</a>
                                <a href="" class="btn  btn-danger"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                    Download</a>

                                <form style="display: inline;" method="post"
                                      action="{{ url('/admin/forms/' . $questionnaire->id) }}">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to remove this Questionnaire?')">
                                        <span class="fa fa-trash"></span> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <h2>{{ $questionnaire->name }}</h2>
                        <p>{{ $questionnaire->description }}</p>
                        <p><strong>Number of Responses:</strong> Add feature later...</p>

                    </div>
                </div>


            @else
                <a href="/admin/forms/create?flag={{ $flag }}&resolution_id={{$resolution->id}}" class="btn btn-success">Questionnaire</a>
            @endif

            {{-- If there is none--}}

        </div>
    @endif
    <div class="col-md-5">
        <div class="row">
            <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-file-text"></i> resolution {{ $resolution->number }}
                        : {{  $resolution->title }}</h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Resolution Number</th>
                            <td>{{ $resolution->number }}</td>
                        </tr>
                        <tr>
                            <th>Series</th>
                            <td>{{ $resolution->series }}</td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>{{ $resolution->title }}</td>
                        </tr>
                        <tr>
                            <th>Keywords</th>
                            <td>{{ $resolution->keywords }}</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        @if($resolution->is_monitoring === 1)
            <div class="row">
                <div class="box box-default color-palette-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-comments-o"></i> Comments/Suggestions</h3>
                    </div>

                    <div class="box-body box-comments">
                        @foreach($resolution->suggestions as $suggestion)
                            <div class="box-comment">
                                <!-- User image -->
                                {{--<img class="img-circle img-sm" src="/dist/img/user3-128x128.jpg" alt="User Image">--}}

                                <div class="comment-text">
                              <span class="username">
                                {{ $suggestion->first_name }} {{ $suggestion->last_name }}
                                  <span class="text-muted pull-right">{{ $suggestion->created_at }}</span>
                              </span><!-- /.username -->
                                    {{ $suggestion->suggestion }}
                                </div>
                                <!-- /.comment-text -->
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-7">
        <iframe src = "/ViewerJS/#../storage/resolutions/{{substr($resolution->pdf_file_path, strrpos( $resolution->pdf_file_path, '/' ) + 1 )}}"
                width='100%' height='400' allowfullscreen webkitallowfullscreen></iframe>
    </div>

    {{--@if($resolution->is_monitoring === 1)--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12">--}}
                {{--<div>--}}
                    {{--<!-- general form elements -->--}}
                    {{--<div class="box box-primary">--}}
                        {{--<div class="box-header with-border">--}}
                            {{--<h3 class="box-title">Questionnaires</h3>--}}
                        {{--</div>--}}
                        {{--<div class="box-body">--}}
                            {{--@if($flag !== 'all')--}}
                                {{--<div>--}}
                                    {{--<p>--}}
                                        {{--<a href="/admin/forms/create?flag={{ $flag }}" class="btn btn-success">Create new Questionnaire</a>--}}
                                    {{--</p>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                            {{--<table class="table table-striped table-condensed table-bordered">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Id</th>--}}
                                    {{--<th>Questionnaire Name</th>--}}
                                    {{--<th>Assoc. Oridinance</th>--}}
                                    {{--<th>Assoc. Resolution</th>--}}
                                    {{--<th>Status</th>--}}
                                    {{--<th>Action</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($questionnaires as $questionnaire)--}}
                                    {{--<tr>--}}
{{--                                        <td>{{ $questionnaire->id }}</td>--}}
                                        {{--<td>{{ $questionnaire->name }}</td>--}}
                                        {{-- Refactore below --}}
                                        {{--<td> {{ $questionnaire->ordinance ? $questionnaire->ordinance->title : '-' }}</td>--}}
                                        {{--<td> {{ $questionnaire->resolution ? $questionnaire->resolution->title : '-'}}</td>--}}
                                        {{--<td>--}}
                                            {{--@if($questionnaire->isAccepting == 0)--}}
                                                {{--<span class="label label-danger">Responses Disabled</span>--}}
                                            {{--@else--}}
                                                {{--<span class="label label-success">Accepting Responses</span>--}}
                                            {{--@endif--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="{{"/admin/result/{$questionnaire->id}"}}" class="btn btn-xs btn-success"><span>Results</span></a>--}}
                                            {{--<a href="{{"/admin/forms/{$questionnaire->id}"}}" class="btn btn-xs btn-info"><span>Preview</span></a>--}}
                                            {{--<a href="{{ url("/admin/forms/{$questionnaire->id}/edit") }}"--}}
                                               {{--class="btn btn-xs btn-warning">Edit</a>--}}
                                            {{--<a href="" class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>--}}
                                            {{--Download</a>--}}
                                            {{--@if($questionnaire->isAccepting == 0)--}}
                                                {{--<form style="display: inline;" method="post"--}}
                                                      {{--action="{{ url('/admin/acceptResponses/' . $questionnaire->id) }}">--}}
                                                    {{--{{ csrf_field() }}--}}
                                                    {{--<button class="btn btn-xs btn-success">--}}
                                                        {{--Accept Responses--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@else--}}
                                                {{--<form style="display: inline;" method="post"--}}
                                                      {{--action="{{ url('/admin/declineResponses/' . $questionnaire->id) }}">--}}
                                                    {{--{{ csrf_field() }}--}}
                                                    {{--<button class="btn btn-xs btn-danger">--}}
                                                        {{--Disable Responses--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            {{--@endif--}}
                                            {{--<form style="display: inline;" method="post"--}}
                                                  {{--action="{{ url('/admin/forms/' . $questionnaire->id) }}">--}}
                                                {{--{{ method_field('DELETE') }}--}}
                                                {{--{{ csrf_field() }}--}}
                                                {{--<button class="btn btn-xs btn-danger"--}}
                                                        {{--onclick="return confirm('Are you sure you want to remove this Questionnaire?')">--}}
                                                    {{--Delete--}}
                                                {{--</button>--}}
                                            {{--</form>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endif--}}
@endsection