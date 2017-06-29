@extends('layouts.registrarapp')
@section('content')

<script>
    function displayID() {
        document.getElementById('curriculum_id').value = program_code.value + curriculum_year.value + "-" + course_code.value;
    }
    
    function getProgram() {
        $.ajax({
            type: "GET",
            url: "/getProduct",
            success: function (data) {
                $('#prodName').empty();
                $.each(data, function (index, productTB) {
                    $('#prodName').append('<option value="' + productTB.productID + '">' + productTB.prodName + '</option>');
                });
            }
        });
    }
    ;
</script>

<ul class="nav nav-tabs">
    <li class="active"><a href="{{url('/registrar/curriculum/college')}}">View</a></li>
    <li><a href="{{url('/registrar/curriculum/college/add')}}">Add</a></li>
</ul>
<br>

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div id="imaginary_container">
            Select Program:<br>
            <select class="form-control" name="prodName" id="prodName" onload="getProdNo(this.value)">
                <option></option>
            </select><br>
        </div>
    </div>
</div>
@stop
