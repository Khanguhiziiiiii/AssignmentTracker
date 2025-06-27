@extends('layouts.studentbackend')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
         <h2 class="mb-4" style="font-family: times new roman;"> Welcome, {{ $student->name }}</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('student.home')}}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section>
    <div class="row">
        <!-- Enrolled Courses -->
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4>{{ $courses->count() }}</h4>
                    <p>Enrolled Courses</p>
                </div>
            </div>
        </div>

        <!-- Assignments Summary -->
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h4>{{ $summary['pending'] }}</h4>
                    <p>Pending Assignments</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h4>{{ $summary['missed'] }}</h4>
                    <p>Missed Assignments</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4>{{ $summary['completed'] }}</h4>
                    <p>Completed Assignments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Recent Submissions</h5>
        </div>
        <div class="card-body p-0">
            @if($submissions->isEmpty())
                <p class="text-center p-3">No submissions yet.</p>
            @else
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Assignment</th>
                            <th>Course</th>
                            <!--<th>Submitted At</th>-->
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $s)
                            <tr>
                                <td>{{ $s->assignment->title }}</td>
                                <td>{{ $s->assignment->course->name ?? 'N/A' }}</td>
                                <!--<td>
                                    {{ $s->submitted_at ? $s->submitted_at->format('Y-m-d H:i') : 'N/A' }}
                                </td>-->
                                <td>{{ $s->grade ?? 'Pending' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection