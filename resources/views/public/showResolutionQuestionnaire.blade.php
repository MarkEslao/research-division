@extends('layouts.public')
@section('content')
    <div class="container">
        <div class="container pb-cmnt-container" style="border-top: dotted lightseagreen; padding-top: 20px">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <h2> {{$questionnaire->name}}</h2>
                                {{$questionnaire->description}}
                                <hr>
                                @php
                                    $counter = 1;
                                @endphp
                                <form method="POST" action="{{ url("/submitResolutionAnswers/{$questionnaire->id }/") }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id"
                                           value="{{$questionnaire->ordinance_id === null ? $questionnaire->resolution_id : $questionnaire->ordinance_id}}">
                                    <input type="hidden" name="type"
                                           value="{{$questionnaire->ordinance_id === null ? "resolution" : "ordinance"}}">
                                    <input type="hidden" name="questionnaire_id" value="{{$questionnaire->id}}">
                                    <label for="firstname">First Name {{$required == 1 ? '*' : '(Optional)'}}</label>
                                    <input name="firstname" type="text" class="form-control" value="{{ old('firstname') }}" {{$required == 1 ? 'required' : ''}}>
                                    <label for="lastname">Last Name {{$required == 1 ? '*' : '(Optional)'}}</label>
                                    <input name="lastname" type="text" class="form-control" value="{{ old('lastname') }}" {{$required == 1 ? 'required' : ''}}>
                                    <label for="email">E-mail {{$required == 1 ? '*' : '(Optional)'}}</label>
                                    <input name="email" type="text" class="form-control" value="{{ old('email') }}" {{$required == 1 ? 'required' : ''}}>
                                    <br>
                                    @foreach($questions as $question)
                                        <div class="form-group">

                                            <label for="answer">{{$counter.'. '.$question->question}}</label>

                                            @if($question->type == 'short')
                                                <input name="question_id{{$counter}}" type="hidden" class="form-control" id="answer" value="{{$question->id}}">
                                                <input name="answer{{$counter}}" type="text" class="form-control" id="answer" value="{{ old('answer'.$counter) }}" {{$question->required == 1 ? 'required' : ''}}>
                                            @endif
                                            @if($question->type == 'long')
                                                <input name="question_id{{$counter}}" type="hidden" class="form-control" id="answer" value="{{$question->id}}">
                                                <textarea class="form-control" rows="5" id="answer" name="answer{{$counter}}" {{$question->required == 1 ? 'required' : ''}}>{{ old('answer'.$counter) }}</textarea>
                                            @endif
                                            @if($question->type == 'radio')
                                                <input name="question_id{{$counter}}" type="hidden" class="form-control" id="answer" value="{{$question->id}}">
                                                @foreach($values as $value)
                                                    @if($value->question_id == $question->id)
                                                        <div class="radio">
                                                            <label><input id="answer" type="radio" name="answer{{$counter}}" value="{{$value->value}}" {{ (old('answer'.$counter) == $value->value) ? 'checked' : '' }} {{$question->required == 1 ? 'required' : ''}}>{{$value->value}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if($question->type == 'checkbox')
                                                @foreach($values as $value)
                                                    @if($value->question_id == $question->id)
                                                        <input name="question_id{{$counter}}" type="hidden" class="form-control" id="answer" value="{{$question->id}}">
                                                        <div class="checkbox">
                                                            <label><input type="checkbox" name="answer{{$counter}}" value="{{$value->value}}" {{ (! empty(old('answer'.$counter)) ? 'checked' : '') }} {{$question->required == 1 ? 'required' : ''}}>{{$value->value}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if($question->type == 'conditional')
                                                <input name="question_id{{$counter}}" type="hidden" class="form-control"
                                                       id="answer" value="{{$question->id}}">
                                                @php
                                                    $count=0;
                                                @endphp
                                                @foreach($values as $value)
                                                    @if($value->question_id == $question->id)
                                                        @php
                                                            $split=explode(";",$value->value.";");
                                                            $count=$count+1;
                                                        @endphp
                                                        <div class="radio">
                                                            <label><input id="watch-me{{$count}}" onclick="show{{$count}}({{$counter}})" type="radio" name="answer{{$counter}}" value="{{$split[0]}}" {{$question->required == 1 ? 'required' : ''}}>{{$split[0]}}</label>
                                                        </div>
                                                        @if($split[1]==="1")
                                                            <div id='show-me{{$count}}-{{$counter}}' style='display:none'>
                                                                <textarea class="form-control" rows="5" id="answer" placeholder="Why?" name="{{$count}}conditionalAnswer{{$counter}}" {{$question->required == 1 ? 'required' : ''}}></textarea>
                                                            </div>
                                                        @else
                                                            <div id='show-me{{$count}}-{{$counter}}' style='display:none'>
                                                            </div>
                                                        @endif

                                                    @endif
                                                @endforeach
                                            @endif
                                            @php
                                                $counter = $counter+1;
                                            @endphp
                                        </div>
                                    @endforeach

                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif

                                    <input name="counter" type="hidden" class="form-control" value="{{$counter}}">
                                    <button class="btn btn-success pull-right" type="submit"><i
                                                class="fa fa-paper-plane"></i> Submit
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection