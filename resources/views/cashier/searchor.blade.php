@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
    <div class="form-group">
    </div>    
    <h3>SEARCH OR ISSUED</h3>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Search" id="search">
    </div>
    <div class="form-group">
        <div id="displaylist">
        </div>    
    </div>    
</div>    

<script>
    $(document).ready(function(){
        $("#search").keypress(function(e){
           var theEvent = e || window.event;
           var key = theEvent.keyCode || theEvent.which;
            if(key==13){
                var array = {}
                array['search']=$("#search").val();
                $.ajax({
                    type:"GET",
                    url:"/cashier/ajax/searchor",
                    data:array,
                    success:function(data){
                        $("#displaylist").html(data);
                        $("#search").val("");
                    }
                })
            }
        });
    });
</script>    
@stop
