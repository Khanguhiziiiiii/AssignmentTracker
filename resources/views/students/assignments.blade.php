@extends('layouts.studentbackend')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h2 class="mb-4" style="font-family: times new roman;"> All Assignments</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('student.home')}}">Home</a></li>
          <li class="breadcrumb-item active">Manage Assignments</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-secondary">Assignments: {{ $assignments->count() }}</h3>
                </div>
                <div class="card-body">
                    <table id="example2" class=" table table-stripped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Assignment</th>
                                <th>Course</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->title }}</td>
                                <td>{{ $assignment->course->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignment->duedate)->format('Y-m-d') }}</td>                
                                @php
                                    $submission = $assignment->submissions->where('student_id', Auth::id())->first();
                                    $now = \Carbon\Carbon::now();
                                @endphp
                                <td>
                                    @if($submission)
                                        <span class="badge badge-success">Completed</span>
                                    @elseif(\Carbon\Carbon::parse($assignment->duedate)->lt($now))
                                        <span class="badge badge-danger">Missed</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($assignment->status === 'pending')
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#submitModal{{ $assignment->id }}">
                                            <i class="fa fa-upload"></i> Submit
                                        </button>
                                    @elseif($assignment->status === 'completed' && isset($assignment->submission))
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#submissionModal{{ $assignment->id }}">
                                            <i class="fa fa-eye"></i> View Submission
                                        </button>
                                    @else
                                        <span class="text-muted">No Action</span>
                                    @endif
                                </td>
                                    <!-- Modal for submitting assignment -->
                                    <div class="modal fade" id="submitModal{{$assignment->id}}" tabindex="-1" role="dialog" aria-labelledby="submitModalLabel{{ $assignment->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="background-color: #6f8faf;">
                                                <div class="modal-header" style="border: none;">
                                                    <h5 class="modal-title" id="submitModalLabel{{ $assignment->id }}">Submit Assignment: {{ $assignment->title }}</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file">Upload Your Assignment</label>
                                                            <input type="file" class="form-control-file" id="file" name="file" required>
                                                            <small class="form-text text-muted">Accepted formats: PDF, DOCX, TXT</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-between" style="border: none;">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Submit Assignment</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal for viewing submission -->
                                     <!--@if ($assignment->submission)-->
                                     <div class="modal fade" id="submissionModal{{ $assignment->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $assignment->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="background-color: #6f8faf;">
                                            
                                            <div class="modal-header" style="border: none;">
                                                <h5 class="modal-title" id="modalLabel{{ $assignment->id }}">Your Submission</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            
                                            <div class="modal-body text-center">
                                                <p>You successfully submitted this assignment.</p>
                                            </div>

                                            <div class="modal-footer justify-content-between" style="border: none;">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                <a href="{{ asset('submissions/' . $assignment->submission->file_path) }}" class="btn btn-secondary">
                                                    <i class="fa fa-download"></i> Download PDF
                                                </a>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--@endif-->
                                <td>
                                    @if($assignment->status === 'completed' && isset($assignment->submission->grade))
                                        <span class="badge badge-info">{{ $assignment->submission->grade }}%</span>
                                    @elseif($assignment->status === 'completed')
                                        <span class="text-muted">Not Graded</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No assignments available yet.</td>
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