@extends('admin.layout.app')
@section('body')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Room Create</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
                        <form action="{{route('room.post')}}" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                        @error('room_no')
                        <div class="text-danger text-center">{{$message}}</div>
                        @enderror
                        @error('hotel')
                        <div class="text-danger text-center">{{$message}}</div>
                        @enderror
                        @error('price')
                        <div class="text-danger text-center">{{$message}}</div>
                        @enderror
                        @error('file')
                        <div class="text-danger text-center">{{$message}}</div>
                        @enderror
                        @error('specification.*')
                        <div class="text-danger text-center">Atleast one Specification Field is required</div>
                        @enderror
                        @if (session('sucess'))
                        <div class="text-success text-center">{{session('sucess')}}</div>
                        @endif

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Room No:<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="number" name="room_no" value="{{old('room_no')}}" class="form-control @error('room_no') is-invalid @enderror">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Select Hotel</label>
                                <div class="col-md-6 col-sm-6 ">
                                    <select class="form-control @error('hotel') is-invalid @enderror" name='hotel'>
                                        <option value="">Choose option</option>
                                        @foreach($datas as $data)
                                        <option value="{{$data->id}}" @selected(old('hotel')==$data->id)>{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">price<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="number" name="price" value="{{old('price')}}" id="first-name" class="form-control @error('price') is-invalid @enderror">
                                </div>
                            </div>


                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"> Image<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" id="formFileDisabled">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Specification</label>
                                <div class="col-md-6 col-sm-6 ">

                                    <div class="field_wrapper">
                                            <input type="text" name="specification[]" class="form-control" value="{{old('specification.0')}}"/>
                                            <a href="javascript:void(0);" class="add_button" title="Add field">Add More <i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </div>

                                </div>
                            </div>


                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <a class="btn btn-primary" href="{{route('booking.list')}}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="specification[]" class="form-control" value=""/><a href="javascript:void(0);" class="remove_button"><i class="fa fa-remove"></i></a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
<!-- /page content -->
@endsection

