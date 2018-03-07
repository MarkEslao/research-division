@extends('layouts.admin')

@section('styles')
    <style>
        ul.answer-values > li {
            list-style: none;
            font-size: 15px;
        }

        ul.answer-values {
            height: 200px;
            overflow-y: scroll;
        }

        div.box-primary {
            padding: 5%;
        }
        div.question-print, .rd-header, .code-container{
            display: none;
        }

        @media print {
            .box-header, ul.nav-tabs, .highcharts-button{
                display: none;
            }

            rect.highcharts-container {
                width: 40%;
                height: 50%;
            }

            ul.answer-values {
                display: none;
                overflow: hidden;
            }

            div.question-print{
                display: block;
            }

            .rd-header{
                display: block;
            }
        }

        .fa.fa-print{
            margin-right: 5px;
        }
    </style>

@endsection

@section('content')
    <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
    <div class="box box-primary">
        <div class="box-header with-border">

            <a href="/admin/result/download/{{ $questionnaire->id }}" class="btn btn-success btn-md pull-right">
                <span class="fa fa fa-file-excel-o"> </span> Download Excel
            </a>

            <a onclick="window.print()" class="btn btn-primary btn-md pull-right ">
                <span class="fa fa fa-print"> </span> Print
            </a>

            <h1 class="box-title">Results for:
                <strong>{{ $legislation->title }}</strong>
            </h1>



        </div>
        <div class="box-body">
            <div class="content">
                <div class="rd-header row">
                    <div class="col-md-8">
                        place image here
                    </div>
                    lorem ipsum...
                    <div class="col-md-12">

                    </div>
                </div>
                @foreach( $questionnaire->questions as $question)
                    <div class="row box box-widget" style="margin: 5% 0">
                        <div class="box-header with-border">
                            <div class="user-block">
                                <h3> {{ $question->question}} </h3>
                            </div>
                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>

                        </div>
                        <div class="box-body">
                            <div class="col-md-5">
                                <ul class="answer-values">
                                    @foreach( $question->answers as $answer )
                                            <li id="item{{$answer->id}}">
                                                @if($question->type === "short")
                                                    <a href="" class="update" data-url="{{ url('/admin/updateAnswer/') }}" data-name="name" data-type="text" data-pk="{{$answer->id}}" data-title="Enter answer">{{ $answer->answer }}</a>
                                                @elseif($question->type === "long")
                                                    <a href="" class="update" data-url="{{ url('/admin/updateAnswer/') }}" data-name="name" data-type="textarea" data-pk="{{$answer->id}}" data-title="Enter answer">{{ $answer->answer }}</a>
                                                @else
                                                    {{$answer->answer}}
                                                @endif
                                                    <a class="delete-modal text-danger" data-id="{{$answer->id}}" data-answer="{{$answer->answer}}">
                                                        <span class="glyphicon glyphicon-remove"></span></a>
                                                    {{--<form action="/admin/result/{{ $answer->id }}" method="post">--}}
                                                        {{--{{ method_field('DELETE') }}--}}
                                                        {{--{{ csrf_field() }}--}}
                                                        {{--<button class="btn btn-xs btn-danger btn-equal-width ">Delete</button>--}}
                                                    {{--</form>--}}
                                            </li>
                                    @endforeach
                                </ul>
                            </div>
                            {{-- Put graphs below  for each question --}}
                            <div class="col-md-7">
                                <code class="code-container">
                                    {{-- Here is the data--}}
                                    {{ $question->getAnswerCounts() }}
                                </code>
                                {{-- start of drop down list--}}

                                <!-- Nav tabs -->
                                <div class="question-print">
                                    <h3> {{ $question->question}} </h3>
                                </div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link selected" data-toggle="tab" role="tab" href={{ '#pie' . $question->id }} >Pie</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" role="tab" href={{ '#bar'. $question->id}} >Bar</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" id={{ 'pie'. $question->id}} >
                                        <div class="pieChart"></div>
                                    </div>
                                    <div class="tab-pane " role="tabpanel" id={{ 'bar'. $question->id}} >
                                        <div class="barGraph"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to delete this comment?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_delete" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="answer">Answer:</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="answer_delete" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Delete
                        </button>
                        <button type="button" class="btn" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/bower_components/highcharts/highcharts.js"></script>
    <script src="/bower_components/highcharts/exporting.js"></script>
    <script src="/bower_components/highcharts/offline-exporting.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    {{--pie chart --}}
    <script>
        $(document).ready(function () {
            $('code').each(function (i, v) {
                var that = this;
                var object = JSON.parse($(v).text());
                var dataArr = []
                var keys = Object.keys(object);
                for (key in keys) {
                    dataArr.push({
                        name: keys[key],
                        y: object[keys[key]],
                        selected: true
                    });
                }
                //alert(JSON.stringify($(v).parent().find('.currentChart')));
                $(v).parent().find('.pieChart').highcharts({
                    chart: {
                        height: 400, //(3 / 4 * 100) + '%', // 16:9 ratio
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    exporting: {
                        enabled: true,
                        filename: "Pie {{ $questionnaire->name }}",
                        buttons: {
                            contextButton: {
                                menuItems: ['downloadPNG', 'downloadJPEG',]
                            }
                        }
                    },
                    title: {
                        text: 'Results'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Answers',
                        colorByPoint: true,
                        data: dataArr
                    }]
                });
                //alert(JSON.stringify(dataArr));
            });


        });
    </script>

    {{--bar graph--}}
    <script>
        $(document).ready(function () {
            $('code').each(function (i, v) {
                var that = this;
                var object = JSON.parse($(v).text());
                var dataArr = []
                var keys = Object.keys(object);
                for (key in keys) {
                    dataArr.push({
                        name: keys[key],
                        y: object[keys[key]],
                        selected: true
                    });
                }
                //alert(JSON.stringify($(v).parent().find('.currentChart')));
                $(v).parent().find('.barGraph').highcharts({
                    chart: {
                        height: 400,//(3 / 4 * 100) + '%', 4:3 16:9 ratio
                        type: 'column'
                    },
                    exporting: {
                        enabled: true,
                        filename: "Bar {{ $questionnaire->name }}",
                        buttons: {
                            contextButton: {
                                menuItems: ['downloadPNG', 'downloadJPEG',]
                            }
                        }
                    },
                    title: {
                        text: 'Results'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        bar: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Answers',
                        colorByPoint: true,
                        data: dataArr
                    }]
                });
//                alert(JSON.stringify(dataArr));
            });


        });
    </script>

    <script>
//        $.fn.editable.defaults.send = "always";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.fn.editable.defaults.mode = 'inline';
        $(function(){
            $('.update').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params._token = $("#_token").data("token");
                    params.name = $(this).editable().data('name');
                    return params;
                },
                validate: function(value) {
                    if($.trim(value) == '')
                        return 'This field is required';
                },
                title: 'Enter answer'
            });
        });
        $(function(){
            $('.update').editable.editable('validate');
        });

        $(document).on('click', '.delete-modal', function() {
            $('.modal-title').text('Delete');
            $('#id_delete').val($(this).data('id'));
            $('#answer_delete').val($(this).data('answer'));
            $('#deleteModal').modal('show');
            id = $('#id_delete').val();
        });
        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: 'DELETE',
                url: '/admin/result/' + id,
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data) {
//                    toastr.success('Successfully deleted Post!', 'Success Alert', {timeOut: 5000});
                    console.log(data);
                    $('#item' + data['id']).remove();
                }
            });
        });
    </script>
@endsection