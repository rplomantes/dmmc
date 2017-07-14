<label class="label">Tracks</label>
<select class="form-control" name="acad_prog">
    <option value="">Select Track</option>
@foreach ($datas as $data)
    <option value="{{$data->program_code}}">{{$data->program_name}}</option>
@endforeach
</select>