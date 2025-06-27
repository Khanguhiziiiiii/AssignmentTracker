<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use RealRashid\SweetAlert\Facades\Alert;

class SubmissionController extends Controller
{
public function submissions(Request $request)
{
    $instructor = Auth::user();
    $courses = Course::where('instructor_id', $instructor->id)->get();

    $assignments = collect();
    $submissions = collect();

    if ($request->has('course_id')) {
        $assignments = Assignment::where('course_id', $request->course_id)->get();
    }

    if ($request->has('assignment_id')) {
        $submissions = Submission::with('student')
            ->where('assignment_id', $request->assignment_id)
            ->latest()
            ->get();
    }

    return view('instructors.submission', compact('courses', 'assignments', 'submissions'));
}

}
