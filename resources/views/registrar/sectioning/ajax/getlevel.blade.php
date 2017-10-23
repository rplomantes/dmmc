<?php
$advisers = \App\User::where('accesslevel', 10)->get();
?>
<div class="col-sm-3">
    <label class="label">Section</label>
    <select class="form form-control" id="section" name="section" onchange="getSectionList(this.value, level.value)">
        <option>Select Section</option>
        @foreach($sections as $section)
            <option value="{{$section->section}}">{{$section->section}}</option>
        @endforeach
    </select>
</div>
<div class="col-sm-3">
    <label class="label">Class Adviser</label>
    <select class="form form-control" id="adviser" name="adviser" onchange="assignAdviser(this.value)">
        <option value="None">Select Adviser</option>
        @foreach ($advisers as $adviser)
        <option value="None">None</option>
        <option value="{{$adviser->idno}}">{{$adviser->lastname}}, {{$adviser->firstname}} {{$adviser->middlename}} {{$adviser->extensionname}}</option>
        @endforeach
    </select>
</div>