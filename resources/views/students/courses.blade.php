@extends('layouts.studentbackend')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
         <h2 class="mb-4" style="font-family: times new roman;"> My Courses</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('student.home')}}">Home</a></li>
          <li class="breadcrumb-item active">Manage Courses</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-secondary">Courses: {{ $courses->count() }}</h3>
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#enrollModal">
                        <i class="fas fa-plus-circle"></i> Enroll in a Course
                    </button>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Instructor</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>                
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($courses as $course)
                          <tr>
                              <td>{{ $course->name }}</td>
                              <td>{{ $course->description}}</td>
                              <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                              <td>{{ \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') }}</td>
                              <td>{{ \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') }}</td>
                              <td>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#unenrollCourse{{$course->id}}">
                                    <i class="fas fa-trash"></i> Unenroll
                                </button>
                              </td>
                          </tr>

                            <!-- Unenroll Modal -->
                             <div class="modal fade" id="unenrollCourse{{$course->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="background-color: #6f8faf;">
                                        <div class="modal-header" style="border: none;">
                                            <h5 class="modal-title"><i class="fa fa-trash"></i> Unenroll</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('student.courses.unenroll', ['courseId' => $course->id]) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Are you sure you want to unenroll from <strong>{{ $course->name }}</strong>?</p>
                                                <p>This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between" style="border: none;">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Unenroll</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                          @empty
                          <tr>
                              <td colspan="4">No courses enrolled. Please contact your administrator.</td>
                          </tr>
                          @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<!--Enroll Modal-->
<div class="modal fade" id="enrollModal">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #6f8faf;">
            <div class="modal-header" style="border: none;">
                <h5 class="modal-title"><i class="fa fa-plus"></i>Enroll</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('student.courses.enroll') }}">
                @csrf
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" id="courseSearchInput" placeholder="Search for a course...">

                    <div id="courseList">
                        @foreach ($courses as $course)
                            @if (!in_array($course->id, $enrolledIds))
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2 course-item">
                                    <span class="course-name">{{ $course->name }}</span>
                                    <input type="radio" name="course_id" value="{{ $course->id }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between" style="border: none;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Enroll</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('courseSearchInput').addEventListener('input', function () {
    const query = this.value.trim();
    const courseList = document.getElementById('courseList');

    if (query.length < 2) {
        courseList.innerHTML = '';
        return;
    }

    fetch(`/student/courses/search?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(courses => {
            courseList.innerHTML = '';

            if (courses.length === 0) {
                courseList.innerHTML = '<p class="text-white">No matching courses found.</p>';
                return;
            }

            courses.forEach(course => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('student.courses.enroll') }}';

                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="course_id" value="${course.id}">
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2 course-item">
                        <span class="course-name text-white">${course.name} - ${course.description}</span>
                        <button type="submit" class="btn btn-primary btn-sm">Enroll</button>
                    </div>
                `;

                courseList.appendChild(form);
            });
        })
        .catch(err => {
            console.error('Search failed:', err);
            courseList.innerHTML = '<p class="text-danger">Error loading courses.</p>';
        });
});
</script>
@endsection