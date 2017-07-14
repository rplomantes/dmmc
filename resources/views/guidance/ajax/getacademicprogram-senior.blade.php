<label class="label">Tracks</label>
<select class="form-control" name="acad_prog">
    <option value="">Select Track</option>
@foreach ($datas as $data)
    <option value="{{$data->track}}">{{$data->track}}</option>
@endforeach
</select>