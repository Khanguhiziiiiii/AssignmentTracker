<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Submission;
use Carbon\Carbon;


class StudentController extends Controller
{
    public function dashboard()
{
    $student = Auth::user();

    $courses = $student->courses ?? collect();
    $assignments = Assignment::whereIn('course_id', $courses->pluck('id'))->get();

    $submissions = Submission::where('student_id', $student->id)->with('assignment')->latest()->take(5)->get();

    $now = Carbon::now();
    $summary = [
        'total' => $assignments->count(),
        'completed' => $assignments->filter(function ($a) use ($student) {
            return $a->submissions->where('student_id', $student->id)->isNotEmpty();
        })->count(),
        'missed' => $assignments->filter(function ($a) use ($student, $now) {
            return $a->submissions->where('student_id', $student->id)->isEmpty() && $a->duedate < $now;
        })->count(),
        'pending' => $assignments->filter(function ($a) use ($student, $now) {
            return $a->submissions->where('student_id', $student->id)->isEmpty() && $a->duedate >= $now;
        })->count(),
    ];

    return view('students.dashboard', compact('student', 'courses', 'summary', 'submissions'));
}

    public function showMyCourses()
{
    $student = Auth::user();

    $courses = $student->courses()->with('instructor')->get();
    $enrolledIds = $courses->pluck('id')->toArray();

    return view('students.courses', compact('courses', 'enrolledIds'));
}


    public function searchCourses(Request $request)
{
    $query = $request->query('query');

    $student = Auth::user();

    $enrolledIds = $student->courses->pluck('id')->toArray();

    $results = Course::whereNotIn('id', $enrolledIds)
        ->where(function ($q) use ($query) {
            $q->where('name', 'like', "%$query%")
              ->orWhere('description', 'like', "%$query%");
        })
        ->with('instructor')
        ->limit(10)
        ->get();

    return response()->json($results);
}

public function enroll(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
    ]);

    $student = Auth::user();

    if ($student->courses()->where('course_id', $request->course_id)->exists()) {
        Alert::error('Error', 'You are already enrolled in this course.');
        return redirect()->back();
    }

    $student->courses()->attach($request->course_id);

    Alert::success('Success', 'Successfully enrolled in the course!');
    return redirect()->back();
}

public function unenroll($courseId)
{
    $student = Auth::user();

    
    if (!$student->courses()->where('course_id', $courseId)->exists()) {
        Alert::error('Error', 'You are not enrolled in this course.');
        return redirect()->back();
    }

    $student->courses()->detach($courseId);

    Alert::success('Success', 'Successfully unenrolled from the course.');
    return redirect()->back();
}

}