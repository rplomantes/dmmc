<label class="label">Academic Program</label>
<select class="form-control" name="acad_prog" id="acad_prog">
    <option value="">Select Academic Program</option>
    @foreach ($datas as $data)
    <option>{{$data->academic_program}}</option>
@endforeach
</select>