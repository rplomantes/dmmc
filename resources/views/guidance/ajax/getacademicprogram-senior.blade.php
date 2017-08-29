<label class="label">Strands</label>
<select class="form-control" name="acad_prog">
    <option value="">Select Strand</option>
@foreach ($datas as $data)
    <option value="{{$data->track}}">{{$data->track}}</option>
@endforeach
</select>