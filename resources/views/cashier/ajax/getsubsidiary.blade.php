<select class="form form-control" name="subsidiary[]" id="subsidiary{{$i}}" onkeypress="gotoexplanation({{$i}},event)">
    @foreach($otherpayments as $payment){
    <option value="{{$payment->subsidiary}}">{{$payment->subsidiary}}</option>
    @endforeach
</select>    
