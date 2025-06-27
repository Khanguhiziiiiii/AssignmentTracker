@extends('layouts.instructorbackend')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
         <h2 class="mb-4" style="font-family: times new roman;"> Assignment Submissions</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('instructor.home')}}">Home</a></li>
          <li class="breadcrumb-item active">Manage Submissions</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
    <div class="container-fluid">

        <!-- Course Selection -->
        <form method="GET" action="{{ route('instructor.submissions') }}">
            <div class="form-group">
                <label for="course">Select Course:</label>
                <select name="course_id" id="course" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Choose Course --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            @if(request('course_id'))
            <!-- Assignment Selection -->
            <div class="form-group">
                <label for="assignment">Select Assignment:</label>
                <select name="assignment_id" id="assignment" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Choose Assignment --</option>
                    @foreach($assignments as $a)
                        <option value="{{ $a->id }}" {{ request('assignment_id') == $a->id ? 'selected' : '' }}>{{ $a->title }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </form>

        @if(request('assignment_id'))
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Submissions ({{ $submissions->count() }})</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Submitted At</th>
                            <th>File</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                        <tr>
                            <td>{{ $submission->student->name }}</td>
                            <td>
                                {{ $submission->submitted_at ? $submission->submitted_at->format('Y-m-d H:i') : 'N/A' }}
                            </td>

                            <td><a href="{{ asset('submissions/' . $submission->file_path) }}">Download</a></td>
                            <td>{{ $submission->grade ?? 'Not graded' }}</td>
                            <td>
                                @if(is_null($submission->grade))
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gradeModal{{ $submission->id }}">
                                        Grade
                                    </button>
                                @else
                                    <span class="badge badge-success">Graded</span>
                                @endif
                                <!-- Grade Modal -->
                                <div class="modal fade" id="gradeModal{{ $submission->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <form method="POST" action="{{ route('instructor.grades', $submission->id) }}">
                                            @csrf
                                            <div class="modal-content" style="background-color: #6f8faf;">
                                                <div class="modal-header" style="border: none;">
                                                    <h5 class="modal-title">Grade Submission</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Grade</label>
                                                        <input type="number" name="grade" class="form-control" min="0" max="100" required value="{{ $submission->grade }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Comments (optional)</label>
                                                        <textarea name="comments" class="form-control">{{ $submission->comments }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-between" style="border: none;">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
