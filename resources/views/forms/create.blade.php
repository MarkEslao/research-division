@extends('layouts.admin')

@section('content')

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Create Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Form Name</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Form 25">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                        <textarea class="form-control" name="" id="" cols="30" rows="3"></textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button class="btn btn-success pull-right" id="add-question">Add Question</button>
                    </div>
                    Action
                    <div class="box-header with-border">
                        <h3 class="box-title" >Create Question</h3>
                    </div>
                    <div  id="question-template">

                        <div class="box-body col-md-8">
                            <label for="">Question</label>
                            <input class="form-control input-lg" type="text" placeholder="Question">
                            Answer Type:
                            <div >
                                <select name="" id="" class="form-control">
                                    <option value="">Short Answer</option>
                                    <option value="">Long Answer</option>
                                    <option value="">Multiple Choice</option>
                                    <option value="">Checkboxes</option>
                                    <option value="">Dropdown</option>
                                </select>
                            </div>
                            <form action="">Answer</form>
                            <input class="form-control input-lg" type="text" placeholder="Answer">

                        </div>

                        <!-- /.box-body -->
                    </div>
                    <div class="row" id="questions-list">

                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.box -->


    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            $("#add-question").click(function(e){
                e.preventDefault();
                var template = $('#question-template').clone(true);
                $('#questions-list').append(template);
            });
        });
    </script>
@endsection