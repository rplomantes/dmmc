<table class="table table-condensed table-striped">
    <tr><th>Tudent ID</th><th>Student Name</th><th>Course</th>Action</th></tr>
    @if(count($lists)>0)
    @else
    <tr><td colspan="4">Record Not Found!!!</td></tr>
    @endif
</table>    
