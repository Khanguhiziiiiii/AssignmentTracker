@extends('layouts.studentbackend')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h2 class="mb-4" style="font-family: times new roman;"> Upcoming Deadlines</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('student.home')}}">Home</a></li>
          <li class="breadcrumb-item active">Upcoming Deadlines</li>
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
                    <h3 class="text-secondary">Assignments: {{ $assignments->count() }}</h3>
                </div>
                <div class="card-body">
                    <table id="example2" class=" table table-stripped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Due Date</th>
                        </tr>
                        </thead>
                        <tbody>
                           @forelse ($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->title }}</td>
                                <td>{{ $assignment->course->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignment->duedate)->format('Y-m-d') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">No upcoming assignments.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

