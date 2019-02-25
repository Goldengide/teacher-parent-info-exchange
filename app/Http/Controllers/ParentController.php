<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ParentController extends Controller
{
    //
    public function dashboard() {
    	$noOfStudents = 20; 
    	$noOfSubjects = 15;
    	return view('parent-dashboard', compact('noOfStudents, noOfSubjects'));
    }

    public function viewTeachers() {}

    public function viewChild($id) {

    }
    public function logAComplaintToThePoprietor() {}
    public function viewChildResult() {}
    public function message() {}
    public function profilePicsUpdatePage($id) {
        $student = Student::where('id', $id)->first();
        return view('pages.parent-student-upload-pics', compact('student')); 
    }
    public function profilePicsUpdateAction(Request $request) {
        /*$id = $request->id;
        $file = $request->file;
        $user = User::find($id);
        $user->img_url*/

        $id = $request->id;
        $student = Student::find($id);
        $file = $request->photo;

        $previousFilename = $file->getClientOriginalName();
        $filename = $request->email ."_". $request->student_name .".". explode(".", $previousFilename)[count(explode(".", $previousFilename)) - 1];



        if($request->hasFile('photo')) {
            if ($file->isValid()) {
                
                if($file->move( URL::asset('/public/uploads/images') , $filename)) {
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
