@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        @if($resolution->is_monitoring == 0)
            <li><a href="/admin/resolutions"><i class="fa fa-book"></i> Research & Records</a></li>
            <li><a href="/admin/resolutions">Resolutions</a></li>
        @else
            <li><a href="/admin/forms/resolutions"><i class="fa fa-bar-chart"></i> Monitoring & Evaluation</a></li>
            <li><a href="/admin/forms/resolutions">Resolutions</a></li>
        @endif
        <li class="active">{{$resolution->id}}</li>
    </ol>

    @if($resolution->is_monitoring === 1)
        {{-- IS in M&E --}}
        <div class="box box-primary color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text"></i> Questionnaire</h3>
            </div>
            <div class="box-body">
                <div class="col-xs-12">

                    @if($questionnaire)
                        {{--It has a questionnaire--}}
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
                                    @if(!$questionnaire->hasAnswers())
                                        <a href="{{ url("/admin/forms/{$questionnaire->id}/edit") }}"
                                           class="btn  btn-warning"><span class="fa fa-edit"></span> Edit</a>
                                    @endif
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
                                {{--<a href="{{"/admin/forms/{$questionnaire->id}"}}" class="btn btn-info"><span><span--}}
                                                {{--class="fa fa-eye"></span> Preview</span></a>--}}
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
                                    <br>
                                    @if($questionnaire->isAccepting == 1)
                                        Public Link: <a href="/public/showResolutionQuestionnaire/{{$resolution->id}}">http://localhost:8000/public/showResolutionQuestionnaire/{{$resolution->id}}</a>
                                        <br>
                                        Required Link: <a href="/public/showResolutionQuestionnaire/{{$resolution->id}}/required">http://localhost:8000/public/showResolutionQuestionnaire/{{$resolution->id}}/required</a>
                                    @endif

                            </div>
                        </div>
                        {{--<h2>{{ $questionnaire->name }}</h2>--}}
                        <p>{{ $questionnaire->description }}</p>
                        <p><strong>Number of Responses:</strong> {{ $questionnaire->getResponseCount() }}</p>
                    @else
                        <div class="col-xs-12">
                            <a href="/admin/forms/create?flag={{ $flag }}&resolution_id={{$resolution->id}}"
                               class="btn btn-success">Create Questionnaire</a>
                        </div>
                    @endif
                </div>
            </div>
            {{-- If there is none--}}

        </div>
    @endif

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

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="box box-success color-palette-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-file-text"></i> RESOLUTION {{ $resolution->number }}</h3>
                        <div class="pull-right">
                            <a href="/admin/resolutions/{{$resolution->id}}/edit?type={{$resolution->is_monitoring === 1 ? 'ME' : 'RR'}}"
                               class="btn btn-xs btn-warning">
                                <i class="fa fa-edit"></i>
                                Edit
                            </a>
                            <a href="{{($resolution->pdf_file_path === "" or $resolution->pdf_file_path == null) ? '#' : ("/downloadPDF/resolutions/".$resolution->pdf_file_name)}}"
                               class="btn btn-xs btn-primary {{($resolution->pdf_file_path === "" or $resolution->pdf_file_path == null) ? 'disabled' : ''}}">
                                <i class="fa fa-download"></i>
                                Download Resolution
                            </a>
                        </div>
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
                    <div class="box box-danger color-palette-box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-comments-o"></i> Comments/Suggestions</h3>
                            @if($resolution->is_accepting == 0)
                                <form style="display: inline;" method="post"
                                      action="{{ url('/admin/acceptSuggestions/' . $resolution->id.'/'.$flag) }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-success pull-right">
                                        <span class="fa fa-comments-o"></span> Accept Suggestions
                                    </button>
                                </form>
                            @else
                                <form style="display: inline;" method="post"
                                      action="{{ url('/admin/declineSuggestions/' . $resolution->id.'/'.$flag) }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger pull-right">
                                        <span class="fa fa-times"></span> Decline Suggestions
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="box-body box-comments">
                            @php
                                $counter=0;
                            @endphp
                            @foreach($resolution->suggestions as $suggestion)
                                @if($counter == 3)
                                    @php
                                        break;
                                    @endphp
                                @endif
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
                                    @php
                                        $counter=$counter+1;
                                    @endphp
                            @endforeach
                            <a href="/admin/showComments/{{$resolution->id}}/resolutions" class="pull-right">View all</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if($resolution->is_monitoring === 1)
            <div class="col-md-6">
                <div class="box box-success color-palette-box">
                    <div class="box-header with-border">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#status">Status Report</a></li>
                            <li {{($resolution->statusReport === null or $resolution->statusReport->pdf_file_path === " ") ? "class=disabled" : ' '}}>
                                <a {{($resolution->statusReport === null or $resolution->statusReport->pdf_file_path === " ") ? ' ' : "data-toggle=tab" }} href="#update">
                                    Update Reports
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="box-body">
                        <div class="tab-content">
                            <div id="status" class="tab-pane fade in active">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col-md-12">
                                        <a href="/admin/resolutions/{{$resolution->id}}/upload-status-report" class="btn btn-xs btn-group btn-soundcloud">
                                            <i class="fa fa-file-text"></i>
                                            {{($resolution->statusReport === null or $resolution->statusReport->pdf_file_path === " ") ? 'Upload' : 'Reupload'}} Status Report
                                        </a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        @if($resolution->statusReport !== null and $resolution->statusReport->pdf_file_path !== " ")
                                            <table class="table table-striped table-bordered">
                                                <tr class="text-center">
                                                    <th>Status Report Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                <tr>
                                                    <td>{{$resolution->statusReport->pdf_file_name}}</td>
                                                    <td>
                                                        <a href="/downloadPDF/statusreports/{{$resolution->statusReport->pdf_file_name}}"
                                                           class="btn btn-xs btn-primary btn-equal-width">
                                                            Download
                                                        </a>
                                                        <a href="/deletePDF/statusreports/{{$resolution->statusReport->pdf_file_name}}"
                                                           class="btn btn-xs btn-danger btn-equal-width deletePDFButton">
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        @else
                                            <div class="row text-center">
                                                <h4>No uploaded status report.</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="update" class="tab-pane fade">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col-md-12">
                                        <a href="/admin/resolutions/{{$resolution->id}}/upload-update-report"
                                           class="btn btn-xs btn-group btn-primary ">
                                            <i class="fa fa-file-text"></i>
                                            Upload Update Report
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($resolution->updateReport()->where('is_deleted', 0)->first())
                                            <table class="table table-striped table-bordered">
                                                <tr class="text-center">
                                                    <th>Update Report Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                @foreach($resolution->updateReport()->where('is_deleted', 0)->get() as $updateReport)
                                                    <tr>
                                                        <td>{{$updateReport->pdf_file_name}}</td>
                                                        <td>
                                                            <a href="/downloadPDF/updatereports/{{$updateReport->pdf_file_name}}"
                                                               class="btn btn-xs btn-primary btn-equal-width">
                                                                Download
                                                            </a>
                                                            <a href="/deletePDF/updatereports/{{$updateReport->pdf_file_name}}"
                                                               class="btn btn-xs btn-danger btn-equal-width deletePDFButton">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @else
                                            <div class="row text-center">
                                                <h4>No uploaded update reports.</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    @if($resolution->is_monitoring == 1)
        <div class="row">
            @endif

            @if($resolution->is_monitoring === 1)
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger color-palette-box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-comments-o"></i> Comments/Suggestions Statistics</h3>
                            </div>
                        </div>
                    </div>
                </div>
    @endif
@endsection
            @section('scripts')
                <script type="text/javascript">
                    $('.deletePDFButton').click(function(e) {
                        var link = e.target;
                        var fileName = $(link).parent().parent().children().first().text();

                        return confirm( "Are you sure you want to delete the file " + fileName +"?");
                    });
                </script>
@endsection