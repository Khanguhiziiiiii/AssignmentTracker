<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubmissionController;  
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();


Route::get('instructor/home', [HomeController::class, 'instructorHome'])->name('instructor.home')->middleware('isAdmin');
Route::get('student/home', [HomeController::class, 'studentHome'])->name('student.home');


// Forgot Password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


// Reset Password
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('/force-logout', function () {
    Auth::logout();
    return redirect('/login');
});


Route::get('/redirect-after-login', function () {
    $user = Auth::user();

    if ($user->is_admin == 1) {
        return redirect()->route('instructor.home');
    }

    return redirect()->route('student.home');
})->middleware('auth');


// Instructor routes 
Route::middleware(['auth', 'isAdmin'])->prefix('instructor')->name('instructor.')->group(function () {


    // Dashboard
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('dashboard');


    // Assignments
    Route::get('/assignments', [AssignmentController::class, 'showMyAssignments'])->name('assignments');
    Route::post('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments/update', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::post('/assignments/delete', [AssignmentController::class, 'delete'])->name('assignments.delete');    


    // Courses
    Route::get('/courses', [InstructorController::class, 'showMyCourses'])->name('courses');
    Route::post('/courses/create', [InstructorController::class, 'create'])->name('courses.create');
    Route::post('/courses/update', [InstructorController::class, 'update'])->name('courses.update');
    Route::post('/courses/delete', [InstructorController::class, 'delete'])->name('courses.delete');
    

    // View enrolled students
    Route::get('/enrolled-students', [InstructorController::class, 'students'])->name('students');


    // Submissions
    Route::get('/submissions', [SubmissionController::class, 'submissions'])->name('submissions');


    // Grade assignments
    Route::post('/grades/{submission_id}', [GradeController::class, 'index'])->name('grades');
});



// Student Routes
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {


    // Dashboard
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');


    // My Courses
    Route::get('/courses', [StudentController::class, 'showMyCourses'])->name('courses');
    Route::post('/enroll', [StudentController::class, 'enroll'])->name('courses.enroll');
    Route::post('/unenroll/{courseId}', [StudentController::class, 'unenroll'])->name('courses.unenroll');
    Route::get('/courses/search', [StudentController::class, 'searchCourses'])->name('courses.search');


    // Assignments
    Route::get('/assignments', [AssignmentController::class, 'studentAssignments'])->name('assignments');
    Route::post('/assignments/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');


    // My Submissions
    Route::get('/submissions', [AssignmentController::class, 'submissions'])->name('submissions');
    

    // Upcoming Deadlines
    Route::get('/upcoming', [AssignmentController::class, 'upcoming'])->name('upcoming');


    // Missed Submissions
    Route::get('/missed', [AssignmentController::class, 'missed'])->name('missed');


    // View grades
    Route::get('/grades', [GradeController::class, 'grades'])->name('grades');
});