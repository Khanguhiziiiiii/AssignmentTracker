<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use RealRashid\SweetAlert\Facades\Alert;


class GradeController extends Controller
{
    public function index(Request $request, $submission_id)
{
    $submission = Submission::findOrFail($submission_id);

    // Prevent regrading if grade already exists
    if (!is_null($submission->grade)) {
        Alert::error('Error', 'This submission has already been graded and cannot be regraded.');
        return redirect()->back();
    }

    $request->validate([
        'grade' => 'required|numeric|min:0|max:100',
        'comments' => 'nullable|string|max:1000',
    ]);

    $submission->grade = $request->grade;
    $submission->comments = $request->comments;
    $submission->save();

    Alert::success('Success', 'Submission graded successfully!');
    return redirect()->back();
}

}
