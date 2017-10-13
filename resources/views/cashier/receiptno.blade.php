@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
    <form class="form form-horizontal" method="post" action="{{url('setreceipt')}}" onsubmit="if(!confirm('Are you sure?')){return false;}">
      {!!csrf_field()!!}
    <div class="form form-group">
        <div class="col-md-6">
        <label> Current Receipt No</label>
        <input type="text" class="form form-control" value="{{$currentreceipt}}" disabled="disabled" name="oldnumber">
    </div>  
       
     
        <div class="col-md-6">
        <label> Change To;</label>
        <input type="text" class="form form-control"  name="newnumber">
    </div>
    </div>     
       
    <div class="form form-group">
         
         <div class="col-md-6">
             <a href="{{url('/')}}" class="btn btn-primary form-control">Back To Main</a>
         </div>    
        <div class="col-md-6">
           
        <input type="submit" class="form-control btn btn-primary" value="Set New Receipt Number">
    </div>
    </div>    
    </form>    
</div>
@stop
