<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Student;
use App\StudentDetail;
use Auth;

class ParentController extends Controller
{
    //
    public function dashboard() {
        $children = Student::where('parent_name', Auth::user()->fullname)->get();
        $countChildren = Student::where('parent_name', Auth::user()->fullname)->count();
        // return $countChildren;
        if($countChildren == 1) {
            $child = $children[0];
            return view('pages.parent-students-profile', compact('child', 'countChildren'));
        }
        else if($countChildren > 1) {
            return view('pages.parent-students-index', compact('children', 'countChildren'));
        }

        else {
            return view('pages.parent-dashboard');
        }
    }


    public function teacherProfile($id) {
        $teacher = user::where('id', $id)->first();
        return view('pages.parent-teacher-profile', compact('teacher'));
    }

    public function viewChild($studentId) {
        $showResult = false;
        $season = Season::where('current', 1)->first();
        $seasonId = $season->id;
        $result = $StudentSummary::where('student_id', $studentId)->where('season_id', $seasonId)->count();
        $countChildren = Student::where('parent_name', Auth::user()->fullname)->count();
        $child = Student::where('student_id', $studentId);
        return view('pages.parent-students-profile', compact('child', 'countChildren', 'showResult'));
    }
    public function logAComplaintToThePoprietor() {}
    public function viewChildResult($id) {
        $summary = StudentSummary::where('student_id', $student_id)->first();
        $resultObject = Result::where('season_id', $seasonId)->where('class_id', $classId)->where('student_id', $studentId);
        $results = $resultObject->orderBy('subject')->get();
        return view('pages.parent-students-result-index', compact('results', 'summary'));
    }
    // public function message() {}
    public function profilePicsUpdatePage($id) {
        $student = Student::where('id', $id)->first();
        return view('pages.parent-student-upload-pics', compact('student')); 
    }
    public function profilePicsUpdateAction(Request $request) {

        $id = $request->id;
        $student = Student::find($id);
        $file = $request->file('photo');

        $previousFilename = $file->getClientOriginalName();
        $filename = $request->email ."_". $request->student_name .".". explode(".", $previousFilename)[count(explode(".", $previousFilename)) - 1];



        if($request->hasFile('photo')) {
            if ($file->isValid()) {
                
                if($file->move('uploads/images' , $filename)) {
                    $student->img_url = $filename;

                }

            }
        }
        $isSaved = $student->save();

        if ($isSaved) {
            return redirect()->back()->with(['message' => 'Picture has been changed', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Picture has been changed', 'style' => 'alert-danger']);
        }
    }

   
}
