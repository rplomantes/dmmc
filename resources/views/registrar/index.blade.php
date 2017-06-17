@extends('layouts.registrarapp')
@section('content')

<div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                    <input type="text" id="search" class="form-control"  placeholder="Search" >
                    <span class="input-group-addon">
                            <span class="fa fa-search"></span>      
                    </span>
                </div>
            </div>
        </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div id ="displaystudent">
        </div>    
    </div>    
</div>

<!--Ajax Module-->
<script type="text/javascript">
   $(document).ready(function(){
       $("#search").keypress(function(e){
           var theEvent = e || window.event;
           var key = theEvent.keyCode || theEvent.which;
           var array={};
           array['search']=$("#search").val();
           if(key==13){
               $.ajax({
                   type:"GET",
                   url:"/ajax/getmainstudentlistregistrar",
                   data:array,
                   success:function(data){
                       $("#displaystudent").html(data);
                       $("#search").val("");
                   }
               });
           }
       })
   })
</script>  
@stop
