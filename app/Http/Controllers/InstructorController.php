<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\Submission;

class InstructorController extends Controller
{
    public function dashboard()
{
    $instructor = Auth::user();

    
    $courses = $instructor->taughtCourses()->with('students')->get();  // renamed function

    
    $assignments = Assignment::whereIn('course_id', $courses->pluck('id'))->get();

    
    $submissions = Submission::with('assignment.course', 'student')
                    ->whereIn('assignment_id', $assignments->pluck('id'))
                    ->latest()
                    ->take(5)
                    ->get();

    
    $studentIds = [];
    foreach ($courses as $course) {
        $studentIds = array_merge($studentIds, $course->students->pluck('id')->toArray());
    }

    $uniqueStudentCount = count(array_unique($studentIds));

    $stats = [
        'courses' => $courses->count(),
        'assignments' => $assignments->count(),
        'submissions' => Submission::whereIn('assignment_id', $assignments->pluck('id'))->count(),
        'students' => $uniqueStudentCount,
    ];

    return view('instructors.dashboard', compact('instructor', 'stats', 'submissions'));
}

    public function showMyCourses(){

        $instructorId = Auth::id();

        $courses = Course::where('instructor_id', $instructorId)->latest()->get();
        
        return view('instructors.courses', compact('courses'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $createCourse=Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
            'instructor_id' => Auth::id(),
        ]);
        
        if($createCourse){
        Alert::success('Success', 'Course created successfully!');
        return redirect()->back();
    } else{
        Alert::error('Error', 'Failed to create course!');
        return redirect()->back();
    }
    }

    public function update(Request $request){
        $id= $request-> id;
        $course = Course::find($id);
        if ($course){
            $course->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            Alert::success('Success', 'Course updated successfully!');
            return redirect()->back();
        }else{
            Alert::error('Error', 'Failed to update course!');
            return redirect()->back();
        }
    }

    public function delete(Request $request){
        $id= $request-> id;
        $course= Course::find($id);
        if ($course){
            $course->delete();
            Alert::success('Success', 'Course deleted successfully!');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Failed to delete course!');
            return redirect()->back();
        }
    }

        public function students(Request $request)
    {
        $instructor = Auth::user();

        $courses = $instructor->taughtCourses;

        $selectedCourse = null;

        if ($request->has('course_id')) {
            $selectedCourse = $courses->where('id', $request->course_id)->first();
            if ($selectedCourse) {
                $selectedCourse->load('students'); 
            }
        }

        return view('instructors.student', compact('courses', 'selectedCourse'));
    }


}