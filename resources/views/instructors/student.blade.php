@extends('layouts.instructorbackend')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h2 class="mb-4" style="font-family: times new roman;">Enrolled Students</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('instructor.home') }}">Home</a></li>
          <li class="breadcrumb-item active">Students Enrolled</li>
        </ol>
      </div>
    </div>

    <!-- Course Selection Form -->
    <form method="GET" action="{{ route('instructor.students') }}">
      <div class="form-group">
        <label for="course">Select a Course:</label>
        <select name="course_id" id="course" class="form-control" onchange="this.form.submit()">
          <option value="">-- Choose a Course --</option>
          @foreach ($courses as $course)
            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
              {{ $course->name }}
            </option>
          @endforeach
        </select>
      </div>
    </form>

    @if ($selectedCourse)
      <div class="card">
        <div class="card-header">
          <h4 class="text-secondary mb-0">Students Enrolled in {{ $selectedCourse->name }}</h4>
        </div>
        <div class="card-body">
          @if ($selectedCourse->students->isEmpty())
            <p class="text-muted">No students enrolled in this course yet.</p>
          @else
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selectedCourse->students as $student)
                  <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
