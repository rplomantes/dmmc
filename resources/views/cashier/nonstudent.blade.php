<?php
$receiptno = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
$referenceid = uniqid();
$otherpayment = \App\OtherPayment::distinct()->get(['accounting_name']);
?>



<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DMMCIHS School Management System</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/customize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    
    <!--Jquery -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .other_amount{text-align: right;}
        #submit{visibility: hidden}
        #receivepayment{visibility:hidden}
        #other_total{text-align: right;color: red;font-weight: bold}
        #donereg{visibility:hidden}
        #cashamount, #bank, #checkno, #checkamount,#change{text-align: right}
    </style>
   
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                   
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div style="color:#fff">DMMC INSTITUTE OF HEALTH AND SCIENCE</div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color:#fff">
                                   <i class="fa fa-user"></i>  {{ Auth::user()->lastname }}, {{ Auth::user()->firstname}} 
                                </a>

                                <!--<ul class="dropdown-menu" role="menu">-->
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                             <span style="color:#fff"><i class="fa fa-sign-out"></i> Logout</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                   </li>
                                <!--</ul>-->
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

       
    </div>


<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="col-md-12">
        <a class="btn btn-primary" href="{{url('/')}}">Back</a>
        <a class="btn btn-primary" href="{{url('/othernonstudent')}}">Refresh</a>

    </div>    
    <hr />
    <div class="col-md-12">
        <div class="col-md-6">{{date("M d, Y")}}</div>
        <div class="col-md-6"><div class="nav navbar pull-right"> Receipt No: <span style="font-size:20pt;font-weight:bold;color:red">{{$receiptno->receipt_no}}</span></div></div>
    </div>    
   <hr />  
  <form id="paymentform" class="form-horizontal" method="POST" action="{{url('othernonstudent')}}">
  {!!csrf_field()!!} 
           <input type="hidden" name="receipt_no" value="{{$receiptno->receipt_no}}">
           <input type="hidden" name="referenceid" value="{{$referenceid}}"> 
   <div class="col-md-8">
   <div id="detailed_form">
     <div class="form form-group">
         <label>Receive From :</label>
         <input type="text" class="form form-control" name="receive_from" id="receive_from">
     </div>    
     <div class="form form-group">    
         <div class="crcform">
        <h5>Non-Student Other Payment Details</h5>
           <div class="form form-group">
                        <div class="col-md-2">
                            <span>Account Name</span>
                        </div>

                        <div class="col-md-3">
                            Subsidiary
                        </div>

                        <div class="col-md-3">
                            
                            Particular
                        </div>

                        <div class="col-md-3">
                            Amount
                        </div>
                        <div class="col-md-1">
                        
                        </div>
                        </div>    
            <div  id="dynamic_field">
                        <!--div class="top-row"-->
                        <div class="form form-group">
                        <div class="col-md-2">
                            <input type="text" class="form-control acctname1" id="acctname1" name="acctname[]" onkeypress="processsubsidiary(event,1,this.value);popotherpayment(1)" />
                        </div>

                        <div class="col-md-3 subsidiary1">
                            <select type="text" class="form-control" name="subsidiary[]"  />
                            </select>
                        </div>

                        <div class="col-md-3">
                            
                            <input type="text" class="form form-control" onkeypress="gotoother_amount(1,event)" name="explanation[]" id="explanation1"/>
                        </div>

                        <div class="col-md-3">
                            <input class="form form-control other_amount" type="text" onkeypress="totalOther(event)" onkeyup = "toNumeric(this)" name="other_amount[]" id="other_amount1"/>
                        </div>
                        <div class="col-md-1">
                        <button type="button" name="add" id="add" class="btn btn-success"> + </button></td>
                        </div>
                        </div>    
            </div>
        <div class="form form-group">
        <div class="col-md-3 col-md-offset-8">
            <input disabled="disabled" type="text" class="form form-control" name="other_total" id="other_total" value="0.00">
        </div>
        </div> 
        <div class="form form-group">
        <div class="col-md-3 col-md-offset-8">
           <buton class="btn btn-primary form-control" id="donereg">Done>>></buton>
        </div>     
        </div>   
            
            
    </div>
    
     </div>  
   </div>    
   </div>
   <div class="col-md-4">
       <table border="1" style="backround-color:#ddd" class="table table-striped" id="receivepayment"><tr><th>Payment Type</th><th>Cash Payment</th></tr>
        <tr><td><span>Cash Receive</span></td><td><input type="text" name="cashamount" id="cashamount" class="form form-control"></td></tr>
        <tr><td></td><td><b>Check Payment</b></td></tr>
        <tr><td>Bank</td><td><input type="text" name="bank" id="bank" class="form form-control"></td></tr>
        <tr><td>Check Number</td><td><input type="text" name="checkno" id="checkno" class="form form-control"></td></tr>
        <tr><td>Check Amount</td><td><input type="text" name="checkamount" id="checkamount" class="form form-control"></td></tr>
        <tr><td>Change</td><td><input type="text" name="change" id="change" class="form form-control" disabled="disabled"></td></tr>
        <tr><td>Remarks</td><td><input type="text" name="remarks" id="remarks" class="form form-control" disabled="disabled"></td></tr>
    </table>    
           <input type="submit" class="form form-control btn btn-primary" name="submit" id="submit" value="Process Payment">
   </div>   
   </form>     
 </div>

<script>
        $(document).ready(function(){
        /*    
        $("#paymentform").submit(function(e) {
        target =  e.originalEvent.explicitOriginalTarget.id  || e.target.id
        if ( target == "submit") {
        // let the form submit
        $("#change").removeAttr('disabled');
        return true;
        }
        else {
        
        e.preventDefault();
        return false;
        }
        });
        */
        $("#donereg").click(function(){
        $("#receivepayment").css("visibility",'visible'); 
        $("#cashamount").focus();
        })
        
        $("#checkamount").keyup(function(){
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }
   });
   
   $("#checkamount").keypress(function(e){
       //alert("hello")
       checkFunction(e.keyCode);
       e.preventDefault();
       return false;
   });
        
         $("#receive_from").focus();   
         var i = 1;
         
         $('#add').click(function(){
         
         if($("#acctname"+i).val()== "" || $("#subsidiary" + i).val()=="" || $("#explanation"+i).val()=="" || $("#other_amount" + i).val()==""){
         alert("Please Fill-up Required Fields " + $("#subsidiary" + i).val());
           } else {   
        i++;
        $('#dynamic_field').append('<div id="row'+i+'" class="form form-group">\n\
        <div class="col-md-2"><input class ="form form-control acctname'+i+' id="acctname'+i+'" type="text"  name="acctname[]" onkeypress="processsubsidiary(event,'+i+',this.value);popotherpayment('+i+')" id="acctname'+i+'"/></div>\n\
        <div class="col-md-3 subsidiary'+i+'"><select class="form form-control" id="subsidiary'+i+'"  name="subsidiary[]"/></select></div>\n\
        <div class="col-md-3"><input class="form form-control" type="text" onkeypress = "gotoother_amount('+i+',event)" name="explanation[]" id="explanation'+i+'"></div>\n\
        <div class="col-md-3"><input class="form form-control other_amount" type="text" onkeypress="totalOther(event)" onkeyup = "toNumeric(this)" onkeypress = "totalOther(event)" name="other_amount[]" id="other_amount'+i+'"/></div>\n\
        <div class="col-md-1"><a href="javascript:void()" name="remove"  id="'+i+'" class="btn btn-danger btn_remove">X</a></div></div>');
        $("#acctname"+i).focus()
        }});
            
            $('#dynamic_field').on('click','.btn_remove', function(){
                //alert($(this).attr("id"))
                var button_id = $(this).attr("id");
                $("#row"+button_id+"").remove();
                i--;
                totalamount =0;
                other_amount = document.getElementsByName('other_amount[]');
                for(var i = 0; i < other_amount.length; i++){
                if(other_amount[i].value != ""){    
                totalamount = totalamount+parseFloat(other_amount[i].value)
                }
                }
                $("#other_total").val(totalamount.toFixed(2))
            }); 
            $("#bank").keypress(function(e){
       var ev = e.keyCode || event.which
       if(ev==13){
           $("#checkno").focus();
           e.preventDefault();
           return false;
       }
   })
            $("#receive_from").keypress(function(e){
               var ev = e.keyCode || event.which 
               if(ev==13){
                  if($("#receive_from").val() == ""){
                      alert("Receive From Should Not Be Empty");
                      
                  }else{ 
                  $(".acctname1").focus(); 
               }
           e.preventDefault();
           return false;
            }
            });
            
           $("#checkno").keypress(function(e){
           var ev = e.keyCode || event.which
           if(ev==13){
           $("#checkamount").focus();
           e.preventDefault();
           return false;
            }
            })
            
            $("#cashamount").keyup(function(){
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value =this.value.replace(/[^0-9\.]/g, '');
            }
            })
            
       $("#cashamount").keypress(function(e){
                 
        var ev = e.keyCode || event.which
        switch(ev){
            case 27:
                $("#cashamount").val("");
                $("cashamount").focus();
                break;
            case 13:
                if($("#cashamount").val()==""){
                   $("#cashamount").val("0.00");
                   $("#bank").focus();
                }
                if(parseFloat($("#cashamount").val()) >= parseFloat($("#other_total").val())){
                    $total = parseFloat($("#cashamount").val()) - parseFloat($("#other_total").val())
                    $("#bank").val("");
                    $("#checkno").val("");
                    $("#checkamount").val("");
                    $("#change").val($total.toFixed(2));
                    $("#remarks").removeAttr('disabled');
                    $("#remarks").focus();
                } else {
                    $("#bank").focus();
                }
                e.preventDefault();
                return false;
                break;
        }
    });
            
             $("#remarks").keypress(function(e){
       var ev = e.keyCode || event.which
       if(ev==13){
           if($("#checkamount").val()==""){
               $("#checkamount").val("0.00");
           }
           if($("#cashamount").val()==""){
               $("#cashamount").val("0.00");
           }
           
           $("#submit").css('visibility','visible');
           $("#submit").focus();
           e.preventDefault()
           return false;
       }
   })
            
        });
        
       function toNumeric(obj){
       //alert(obj.value)
        if (obj.value != obj.value.replace(/[^0-9\.]/g, '')) {
          obj.value = obj.value.replace(/[^0-9\.]/g, '');
       }}
       
       function totalOther(e){
           if(e.keyCode == 13){
                        totalamount =0;
                        other_amount = document.getElementsByName('other_amount[]');
                        for(var i = 0; i < other_amount.length; i++){
                        totalamount = totalamount+parseFloat(other_amount[i].value)
                        }
                        $("#other_total").val(totalamount.toFixed(2))
                        $("#add").focus();
                        $("#donereg").css("visibility","visible")
                        e.preventDefault();
                        return false;
                 }
        }
       
       function processsubsidiary(e,i,value){
       //alert("hello")
       event = e.keyCode 
       if(event==13){
           if(value==""){
               alert("Invalid Entry");
           }else{
           var array={};
           array['value'] = value;
           array['i']=i;
           $.ajax({
               type:"GET",
               url:"/cashier/ajax/getsubsidiary",
               data:array,
               success:function(data){
                  $(".subsidiary" + i).html(data);
                  $("#subsidiary" + i).focus();
               }
           });
           
         }
        e.preventDefault();
        return false;
        }
       }
      
    function popotherpayment(i) {
    var otherpayment = [<?php 
    if(count($otherpayment)>0){
        foreach($otherpayment as $op){
            echo '"'.$op->accounting_name.'",';
        }
    }
    ?>];
                
    $( ".acctname" + i ).autocomplete({
      source: otherpayment
    });
    }
   
    function gotoexplanation(i,envt){
        if(envt.keyCode==13){
            $("#explanation" + i).focus();
        }
    }
    
    function gotoother_amount(i,evt){
        if(evt.keyCode==13){
            $("#other_amount" + i).focus()
            evt.preventDefault()
            return false;
        }
    }
    
    function checkFunction(evt){
    if(evt==13){
        
        
        if(parseFloat($("#checkamount").val()) > parseFloat($("#other_total").val())){
            alert("Invalid Amount. The Amount in Check Should Not Be Greater Than " + $("#other_total").val()) 
            $("#checkamunt").val("");
        }else{
            if(parseFloat($("#checkamount").val())+parseFloat($("#cashamount").val()) > parseFloat($("#other_total").val())){
              totalchange=  parseFloat($("#checkamount").val())+parseFloat($("#cashamount").val()) - parseFloat($("#other_total").val());
              $("#change").val(totalchange.toFixed(2))
            }
            if($("#bank").val()==""){
                alert("Please Fill Up Check Details");
                $("#bank").focus();
            }else if($("#checkno").val()==""){
                alert("Please Fill Up Check Number");
                $("#checkno").focus();
            } 
            else if(parseFloat($("#checkamount").val())+parseFloat($("#cashamount").val())< parseFloat($("#other_total").val())){
                alert("Amount Receive Should Be Equal or Greater Than The Amount Collected");
                $("#checkamount").focus();
            }
                else{
                $("#remarks").removeAttr('disabled');
                $("#remarks").focus();
            }
        }}
    }

    </script>
   
<script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>

</body>
</html>

