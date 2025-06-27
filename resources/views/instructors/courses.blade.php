@extends('layouts.instructorbackend')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
         <h2 class="mb-4" style="font-family: times new roman;"> My Courses</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('instructor.home')}}">Home</a></li>
          <li class="breadcrumb-item active">Manage Courses</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-secondary">Courses: {{ $courses->count() }}</h3>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addCourseModal">
                        <i class="fa fa-plus"></i>Create New Course
                    </button>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-stripped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->description }}</td>
                                    <td>{{ \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') }}</td>
                                    <td>{{ $course->created_at ? $course->created_at->diffForHumans() : 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#updateCourseModal{{$course->id}}">
                                            <i class="fa fa-edit"></i>Update
                                        </button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteCourseModal{{$course->id}}">
                                            <i class="fa fa-trash"></i>Delete
                                        </button>
                                    </td>
                                </tr>

                                <!--Update course modal-->
                                <div class="modal fade" id="updateCourseModal{{$course->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: #6f8faf;">
                                            <div class="modal-header" style="border: none;">
                                                <h5 class="modal-title"><i class="fa fa-edit"></i>Update {{$course->name}} {{$course->description}}</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal"></button>
                                            </div>
                                            <form action="{{route('instructor.courses.update')}}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="text" name="id" value="{{$course->id}}" hidden="true">
                                                    <div class="form-group">
                                                        <label>Course Code</label>
                                                        <input type="text" name="name" class="form-control" value="{{$course->name}}" placeholder="Enter course code" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Course Name</label>
                                                        <input type="text" name="description" class="form-control" value="{{$course->description}}" placeholder="Enter course name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Start Date</label>
                                                        <input type="date" name="start_date" class="form-control" value="{{$course->start_date}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>End Date</label>
                                                        <input type="date" name="end_date" class="form-control" value="{{$course->end_date}}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-between" style="border: none;">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!--Delete Course Modal-->
                                <div class="modal fade" id="deleteCourseModal{{$course->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: #6f8faf;">
                                            <div class="modal-header" style="border: none;">
                                            <h5 class="modal-title"><i class="fa fa-trash"></i>Delete {{$course->name}} {{$course->description}}</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <form action="{{route('instructor.courses.delete')}}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="text" name="id" value="{{$course->id}}" hidden="true">
                                                <p>Are you sure you want to delete this course?<br>This action cannot be undone!</p>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between" style="border: none;">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="4">You have not yet created any courses.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #6f8faf;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title">Create New Course</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('instructor.courses.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Course Code</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter course code" required>
                    </div>
                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" name="description" class="form-control" placeholder="Enter course name" required>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between" style="border: none;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection