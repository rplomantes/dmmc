@extends('layouts.deanapp')
@section('content')
<h2 align="center">Unauthorized to Access This Data!!!</h2>
<p align="center">Please refrain from accessing unauthorized data!! <br>
Your Login Credentials are the following: <center><ul align="center"> <li>User ID : {{Auth::user()->idno}}</li>
<li>User Name : {{Auth::user()->lastname}}, {{Auth::user()->firstname}}</li>
</ul></center></p>
@stop
