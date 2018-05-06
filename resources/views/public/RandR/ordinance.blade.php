@extends('layouts.pub2')
@section('content')
    <!--====================================================
                       HOME-P
    ======================================================-->
    <div id="home-p" class="home-p pages-head2 text-center">
        <div class="container">
            <h1 class="wow fadeInUp" data-wow-delay="0.1s">Businessbox is fully responsive and Clean</h1>
            <p>Our Services</p>
        </div><!--/end container-->
    </div>

    <!--====================================================
                          BUSINESS-GROWTH-P1
    ======================================================-->
    <section id="business-growth-p1" class="business-growth-p1 bg-white">
        <div class="container">
            <div class="row title-bar">
                <div class="col-md-12">
                    <h1 class="wow fadeInUp">Ordinances</h1>
                    <div class="heading-border"></div>
                    <p class="wow fadeInUp" data-wow-delay="0.4s">We committed to helping you maintain your oral
                        healthTooth.We are an innovative company. We develop and design websites for costumers around
                        the world. Our clients are some of the most forward-looking companies in the world.</p>

                    <div class="col-md-12" style="margin-bottom: 30px">
                        <div class="pull-right">
                            <a style="min-width: 150px" href="{{ url()->current() }}" class="btn btn-primary">
                                <i class="fa fa-refresh"></i> Reset Filtering
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="ordinance-right">
                        <div class="col-md-12">
                            @if($ordinances->first() === null)
                                <div class="row text-center">
                                    <h1>No results found.</h1>
                                </div>
                                <br>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-gray">
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
                                                Ordinance Number
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
                                        <th><a href="
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
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <form id="ordinance_form" method="get" action="#">
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
                                        <td><input class="btn btn-primary col-12" type="submit" value="Filter"></td>

                                        <button type="submit"
                                                class="btn btn-general btn-blue mr-2" style="display: none">Go
                                        </button>
                                    </form>
                                    @foreach($ordinances as $ordinance)
                                        <tr>
                                            <td class="information"><span> {{ $ordinance->number }} </span></td>
                                            <td class="information"><span> {{ $ordinance->series }} </span></td>
                                            <td class="justify">{{ str_limit($ordinance->title, $limit = 150, $end = '...') }}</td>
                                            <td class="information">{{ str_limit($ordinance->keywords, $limit = 150, $end = '...') }}</td>
                                            <td>
                                                <button onclick="window.location.href='/public/showOrdinance/{{$ordinance->id}}\ ' "
                                                        class="btn btn-info"><span>Read More</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row text-center">
                                {{$ordinances->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection