<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Submission;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;



class AssignmentController extends Controller
{
    //INSTRUCTOR FUNCTIONS
    public function showMyAssignments()
{
    $instructorId = auth()->id();

    $assignments = Assignment::where('instructor_id', $instructorId)
        ->with('course')
        ->latest()
        ->get();

    $courses = Course::where('instructor_id', $instructorId)->get(); // adjust if needed

    return view('instructors.assignments', compact('assignments', 'courses'));
}


    public function create(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'duedate' => 'required|date',
        'course_id' => 'required|exists:courses,id',
    ]);
    

    $createAssignment=Assignment::create([
        'title' => $request->title,
        'description' => $request->description,
        'duedate' => $request->duedate,
        'status' => 'active',
        'course_id' => $request->course_id,
        'instructor_id' => auth()->id(),
    ]);

    if($createAssignment){
        Alert::success('Success', 'Assignment created successfully!');
        return redirect()->back();
    }else{
        Alert::error('Error', 'Failed to create assignment');
        return redirect()->back();
    }
}

    public function update(Request $request){
    $request->validate([
        'id' => 'required|exists:assignments,id',
        'title' => 'required',
        'description' => 'required',
        'duedate' => 'required|date',
        'course_id' => 'required|exists:courses,id',
    ]);
    $assignment = Assignment::find($request->id);
    if ($assignment) {
        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'duedate' => $request->duedate,
            'course_id' => $request->course_id,
        ]);
        Alert::success('Success', 'Assignment updated successfully!');
        return redirect()->back();
    } else {
        Alert::error('Error', 'Assignment not found');
        return redirect()->back();
    }
}

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:assignments,id',
        ]);

        $assignment = Assignment::find($request->id);
        if ($assignment) {
            $assignment->delete();
            Alert::success('Success', 'Assignment deleted successfully!');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Assignment not found');
            return redirect()->back();
        }
    }








    //STUDENT FUNCTIONS
public function studentAssignments()
{
    $student = Auth::user();

    $assignments = Assignment::with(['course', 'submissions']) // Load related course and submissions
        ->whereIn('course_id', $student->courses->pluck('id'))
        ->get()
        ->map(function ($assignment) use ($student) {
            // Get the student's submission for this assignment
            $submission = $assignment->submissions->where('student_id', $student->id)->first();

            $now = now();

            // Determine the assignment status for the student
            if ($submission) {
                $assignment->status = 'completed';
            } elseif ($assignment->duedate < $now) {
                $assignment->status = 'missed';
            } else {
                $assignment->status = 'pending';
            }

            // Attach the submission to the assignment for easy access in the view
            $assignment->submission = $submission;
            $assignment->grade = optional($submission)->grade;

            return $assignment;
        });

    return view('students.assignments', compact('assignments'));
}


public function upcoming()
{
    $student = Auth::user();
    $today = Carbon::today();

    
    $submittedAssignmentIds = Submission::where('student_id', $student->id)
        ->pluck('assignment_id')
        ->toArray();

    $assignments = Assignment::whereIn('course_id', $student->courses->pluck('id'))
        ->where('duedate', '>=', $today)
        ->whereNotIn('id', $submittedAssignmentIds) // exclude submitted
        ->orderBy('duedate')
        ->get();

    return view('students.upcoming', compact('assignments'));
}

public function missed()
{
    $student = Auth::user();
    $today = Carbon::today();

    $assignments = Assignment::whereIn('course_id', $student->courses->pluck('id'))
        ->where('duedate', '<', $today)
        ->whereDoesntHave('submissions', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })
        ->orderBy('duedate', 'desc')
        ->get();

    return view('students.missed', compact('assignments'));
}

public function submissions()
{
    $student = Auth::user();

    $submissions = Submission::with('assignment')
        ->where('student_id', $student->id)
        ->latest()
        ->get();

    return view('students.submissions', compact('submissions'));
}


public function submit(Request $request)
{
    $request->validate([
        'assignment_id' => 'required|exists:assignments,id',
        'file' => 'required|file|mimes:pdf,docx,zip,txt|max:20480', // 20MB max
    ]);

    $studentId = Auth::id();

    if($request->hasfile('file')){
        $file=$request->file('file');
        $extension=$file->getClientOriginalExtension();
        $fileName=time().'.'.$extension;
        $file->move('submissions/',$fileName);

        $existing = Submission::where('assignment_id', $request->assignment_id)
                          ->where('student_id', $studentId)
                          ->first();

        if ($existing) {
            Alert::error('Error', 'You have already submitted this assignment.');
            return redirect()->back();
        }

        $filePath = $fileName; // Use the file name as the path

        $submission=Submission::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $studentId,
            'file_path' => $filePath,
            'submitted_at' => now(),
        ]);

        if ($submission) {
            Alert::success('Success', 'Assignment submitted successfully!');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Failed to submit assignment');
            return redirect()->back();
        }

    } else {
        Alert::error('Error', 'No file uploaded');
        return redirect()->back();
    }

    
}


}

