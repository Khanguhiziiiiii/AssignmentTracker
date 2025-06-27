@extends('layouts.instructorbackend')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="mb-4" style="font-family: 'Times New Roman';">My Assignments</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('instructor.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Manage Assignments</li>
                </ol>
            </div>
        </div>

        @if($errors->any())
            <script>
                window.onload = () => $('#addAssignmentModal').modal('show');
            </script>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="text-secondary">Assignments: {{ $assignments->count() }}</h3>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addAssignmentModal">
                    <i class="fa fa-plus"></i> Create New Assignment
                </button>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Due Date</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ $assignment->course->name ?? 'N/A' }}</td>
                            <td>{{ $assignment->course->description ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($assignment->duedate)->format('Y-m-d') }}</td>
                            <td>{{ $assignment->created_at->diffForHumans() }}</td>
                            <td>
                                <button class="btn btn-success" data-toggle="modal" data-target="#editAssignment{{ $assignment->id }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAssignment{{ $assignment->id }}">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Assignment Modal -->
                        <div class="modal fade" id="editAssignment{{ $assignment->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background-color: #6f8faf;">
                                    <form action="{{ route('instructor.assignments.update') }}" method="POST">
                                        @csrf
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">Edit Assignment</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ $assignment->id }}">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control" name="title" value="{{ $assignment->title }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input type="text" class="form-control" name="description" value="{{ $assignment->description }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Due Date</label>
                                                <input type="date" class="form-control" name="duedate" value="{{ $assignment->duedate }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Course</label>
                                                <select name="course_id" class="form-control" required>
                                                    <option value="">Select Course</option>
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id }}" {{ $assignment->course_id == $course->id ? 'selected' : '' }}>
                                                            {{ $course->name }} - {{ $course->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 d-flex justify-content-between">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Assignment Modal -->
                        <div class="modal fade" id="deleteAssignment{{ $assignment->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background-color: #6f8faf;">
                                    <form action="{{ route('instructor.assignments.delete') }}" method="POST">
                                        @csrf
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title"><i class="fa fa-trash"></i> Delete Assignment</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ $assignment->id }}">
                                            <p>Are you sure you want to delete this assignment?</p>
                                        </div>
                                        <div class="modal-footer border-0 d-flex justify-content-between">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No assignments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Add Assignment Modal -->
<div class="modal fade" id="addAssignmentModal">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #6f8faf;">
            <form action="{{ route('instructor.assignments.create') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title">Add New Assignment</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" value="{{ old('description') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" class="form-control" name="duedate" value="{{ old('duedate') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">
                                    {{ $course->name }} - {{ $course->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
