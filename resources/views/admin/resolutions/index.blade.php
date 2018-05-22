@extends('layouts.admin')

@section('styles')
    <style>
        form {
            display: inline;
        }

        .btn-equal-width {
            margin: 0 auto;
            width: 57px;
        }

        .add-magin {
            margin: 7px 0;
        }
    </style>
@endsection

@section('content')

    <ol class="breadcrumb">
        @if($type === 'RR')
            <li><a href="/admin/resolutions"><i class="fa fa-book"></i> Research & Records</a></li>
        @else
            <li><a href="/admin/forms/resolutions"><i class="fa fa-bar-chart"></i> Monitoring & Evaluation</a></li>
        @endif

        <li class="active">
            @if(strpos(request()->url(), 'forms'))
                {{ app('request')->input('status') === 'monitored' ? 'Monitored Resolutions' : 'Resolutions Currently being Monitored' }}
            @else
                Resolutions
            @endif
        </li>
    </ol>

    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-file-text"></i>
                @if(strpos(request()->url(), 'forms'))
                    {{ app('request')->input('status') === 'monitored' ? 'Monitored Resolutions' : 'Resolutions Currently being Monitored' }}
                @else
                    Resolutions under Research and Records
                @endif
            </h3>
            @if(!request('status'))
                <div class="pull-right">
                    <a href="/admin/resolutions/create?type={{$type}}" class="btn btn-success"><span
                                class="fa fa-plus"></span> Add</a>
                    {{--<a href="/admin{{$type === 'RR' ? '' : '/forms'}}/resolutions" class="btn btn-primary">--}}
                    {{--<i class="fa fa-refresh"></i> Reset Filtering--}}
                    {{--</a>--}}
                </div>
            @endif
        </div>
        <div class="box-body">
            {{--<div class="add-magin">--}}
            {{----}}
            {{--<form action="#" method="get" class="pull-right col-md-4">
                <div class="input-group">
                    <input value="{{ request()->q }}" type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button type="submit" id="search-btn" class="btn btn-flat">
                          <i class="fa fa-search"></i>
                        </button>
                     </span>
                </div>
            </form>--}}
            {{--</div>--}}
            {{--<table class="table table-striped table-bordered">--}}
            {{--<thead>--}}
            {{--<tr>--}}
            {{--<th>Resolution Number</th>--}}
            {{--<th>Series</th>--}}
            {{--<th>Title</th>--}}
            {{--<th>Keywords</th>--}}
            {{--<th>Actions</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($resolutions as $resolution)--}}
            {{--<tr>--}}
            {{--<td>{{ $resolution->number }}</td>--}}
            {{--<td>{{ $resolution->series }}</td>--}}
            {{--<td>{{ str_limit($resolution->title, $limit = 200, $end = '...')  }}</td>--}}
            {{--<td>{{  str_limit($resolution->keywords, $limit = 200, $end = '...')  }}</td>--}}
            {{--<td>--}}
            {{--<a href="/admin/resolutions/{{$resolution->id}}"--}}
            {{--class="btn btn-xs btn-primary btn-equal-width">--}}
            {{--{{ Request::is('admin/forms*') ? 'Profile' : 'View' }}--}}
            {{--</a>--}}
            {{--<a href="/admin/resolutions/{{$resolution->id}}/edit"--}}
            {{--class="btn btn-xs btn-warning btn-equal-width">Edit</a>--}}
            {{--<form action="/admin/resolutions/{{ $resolution->id }}" method="post">--}}
            {{--{{ method_field('DELETE') }}--}}
            {{--{{ csrf_field() }}--}}
            {{--<button class="btn btn-xs btn-danger btn-equal-width">Delete</button>--}}
            {{--</form>--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
            {{--</table>--}}



            @if($resolutions->first() !== null or !request()->has('q'))
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <a href="
                                    @if(request()->colName === 'number' and request()->order === 'desc')
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'number';
                                $currentUrlQueries['order'] = 'asc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @else
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'number';
                                $currentUrlQueries['order'] = 'desc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @endif">
                                Resolution Number
                            </a>
                        </th>

                        <th>
                            <a href="
                                    @if(request()->colName === 'series' and request()->order === 'desc')
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'series';
                                $currentUrlQueries['order'] = 'asc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @else
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'series';
                                $currentUrlQueries['order'] = 'desc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @endif">
                                Series
                            </a>
                        </th>

                        <th>
                            <a href="
                                    @if(request()->colName === 'title' and request()->order === 'desc')
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'title';
                                $currentUrlQueries['order'] = 'asc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @else
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'title';
                                $currentUrlQueries['order'] = 'desc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @endif">
                                Title
                            </a>
                        </th>

                        <th>
                            <a href="
                                    @if(request()->colName === 'keywords' and request()->order === 'desc')
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'keywords';
                                $currentUrlQueries['order'] = 'asc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @else
                            @php
                                $currentUrlQueries = request()->query();
                                $currentUrlQueries['colName'] = 'keywords';
                                $currentUrlQueries['order'] = 'desc';

                                echo request()->fullUrlWithQuery($currentUrlQueries);
                            @endphp
                            @endif">
                                Keywords
                            </a>
                        </th>

                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <form method="get" action="#">
                            {{--                                    {{ dd(array_unique(request()->all())) }}--}}
                            @foreach(array_filter(request()->all(), function($k){ return !starts_with($k, 'col-'); }, ARRAY_FILTER_USE_KEY) as $k => $v)
                                <input type="hidden" name="{{$k}}" value="{{ $v }}">
                            @endforeach
                            <td><input type="text" class="form-control" name="col-number"
                                       value="{{ request()->input('col-number')}}"></td>
                            <td><input type="text" class="form-control" name="col-series"
                                       value="{{ request()->input('col-series')}}"></td>
                            <td><input type="text" class="form-control" name="col-title"
                                       value="{{ request()->input('col-title') }}"></td>
                            <td><input type="text" class="form-control" name="col-keywords"
                                       value="{{ request()->input('col-keywords') }}"></td>
                            <td><input class="btn btn-xs btn-success btn-equal-width" type="submit" value="Filter">
                                <a href="/admin{{$type === 'RR' ? '' : '/forms'}}/resolutions"
                                   class="btn btn-xs btn-primary btn-equal-width">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </td>
                        </form>
                    </tr>
                    @foreach($resolutions as $resolution)
                        <tr>
                            <td>{{ $resolution->number }}</td>
                            <td>{{ $resolution->series }}</td>
                            <td>{{ str_limit($resolution->title, $limit = 200, $end = '...') }}</td>
                            <td>{{ str_limit($resolution->keywords, $limit = 200, $end = '...') }}</td>
                            <td>
                                <a href="/admin/resolutions/{{$resolution->id}}"
                                   class="btn btn-xs btn-primary btn-equal-width">
                                    View
                                </a>

                                <a href="/admin/resolutions/{{$resolution->id}}/edit?type={{$type}}"
                                   class="btn btn-xs btn-warning btn-equal-width ">Edit</a>
                                
                                @if(Auth::user()->hasRole('superadmin'))
                                    <button class="btn btn-xs btn-danger btn-equal-width" data-toggle="modal"
                                            data-target="#exampleModal{{$resolution->id}}">
                                        Delete
                                    </button>
                                @endif


                                <div class="modal fade" id="exampleModal{{$resolution->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel">Confirm Delete</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p> Are you sure you want to delete Resolution {{ $resolution->number }}
                                                        series of {{ $resolution->series }}?</p>
                                                        <p class="text-danger"><strong> Warning: </strong>This action cannot be undone! Please:</p>
                                                        <ol>
                                                            <li>Go to the <a target="_blank" href="/reports" class="btn btn-warning btn-xs">Reports page</a> and download a backup of the series.</li>
                                                            <li>Go to the <a target="_blank" class="btn btn-info btn-xs" href="/admin/showComments/{{ $resolution->id }}/resolutions">comments page for this ordinance</a> and download a copy of the excel file</li>
                                                        </ol>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Cancel
                                                </button>

                                                    <a href="/admin/ordinances/delete/{{$resolution->id}}"
                                                       class="btn btn-sm btn-danger btn-equal-width deleteButton">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row text-center">
                    {{$resolutions->links()}}
                </div>
            @else
                <div class="row text-center">
                    <h1>No results found.</h1>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.deleteButton').click(function (e) {
            var link = e.target;
            var name = $(link).parent().parent().children().first().text();
            var series = $(link).parent().parent().children().eq(1).text();

            return confirm("Are you sure you want to delete Resolution " + name + "-" + series + "?");
        });
    </script>
@endsection