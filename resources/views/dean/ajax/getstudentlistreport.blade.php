<table class="table table-condensed">
    <thead>
        <th>Subject Code</th>
        <th>Subject Name</th>
        <th>Instructor</th>
    </thead>
    @foreach ($subjectlists as $subjectlist)
{{$subjectlist->course_name}}
@endforeach
</table>