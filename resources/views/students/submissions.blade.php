@extends('layouts.studentbackend')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h2 class="mb-4" style="font-family: times new roman;"> My Submissions</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('student.home')}}">Home</a></li>
          <li class="breadcrumb-item active">Submissions</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section>
    <div class="card">
            <div class="card-header">
                <h3 class="text-secondary">Submissions: {{ $submissions->count() }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Assignment</th>
                            <th>Submitted At</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $submission)
                        <tr>
                            <td>{{ $submission->assignment->title ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($submission->submitted_at)->format('Y-m-d h:i A') }}</td>
                            <td>
                                @if($submission->grade !== null)
                                    <span class="badge badge-success">{{ $submission->grade }}%</span>
                                @else
                                    <span class="text-muted">Not Graded</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">No submissions yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection