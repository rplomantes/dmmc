@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
    <form class="form form-horizontal" method="post" action="{{url('setreceipt')}}">
      {!!csrf_field()!!}
    <div class="form form-group">
        <div class="col-md-6">
        <label> Current Receipt No</label>
        <input type="text" class="form form-control" value="{{$currentreceipt}}" disabled="disabled" name="oldnumber">
    </div>  
     <div class="form form-group">
        <div class="col-md-6">
        <label> Change To;</label>
        <input type="text" class="form form-control"  name="newnumber">
    </div>  
    <div class="form form-group">
        <div class="col-md-12">
            <hr />
        <input type="submit" class="form-control btn btn-primary" value="Set New Receipt Number">
    </div>
    </div>    
    </form>    
</div>
@stop
