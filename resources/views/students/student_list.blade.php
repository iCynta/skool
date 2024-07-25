<table class="table table-sm table-striped  mt-3">
        <thead class="bag-dark">
            <tr>
                <th>Si No:</th>
                <th>Admission No</th>
                <th>Name</th>
                <th>Course</th>
                <th>Batch</th>
                <th>Department</th>
                <th>Seat Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $student->admission_no }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->course->name }}</td>
                    <td>{{ $student->batch->name }}</td>
                    <td>{{ $student->department->name }}</td>
                    <td>{{ $student->seat_type }}</td>  
                    <td>
                        <a href="{{ route('students.edit', $student) }}" class=" btn btn-sm btn-warning">Edit</a> &nbsp;
                        <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $students->links() }}