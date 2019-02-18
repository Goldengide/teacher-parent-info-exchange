<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ClassTable;
use App\Student;
use Illuminate\Support\Facades\File;
use Auth;
use DB;

class TeacherController extends Controller
{
    //

    public function dashboard() {
    	$class = ClassTable::where('teacher_id', Auth::user()->id)->value('name');
    	$noOfStudents = Student::where('class', $class)->count();

    	$noOfSubjects = 15;
    	return view('teacher-dashboard', compact('noOfStudents', 'noOfSubjects'));
    }

    

    public function students() {
    	$students = Student::all();
    }

    public function studentsByClass() {
    	$class = ClassTable::where('teacher_id', Auth::user()->id)->value('name');
    	$students = Student::where("class", $class)->get();
    	return view('teacher-students-index', compact('students', 'class'));
    }

    public function uploadStudentsPage() {
    	return view('upload-students-info');
    }

    public function uploadStudentsAction(Request $request) {
    	$file = $request->file('file');

    	/*$this->validate($request, [
            'file' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
        */
    	if($request->hasFile('file')) {
    		if ($file->isValid()) {
    			$filename = $file->getClientOriginalName();
    			$array = explode(".", $filename);
    			$extension = $array[count($array)-1];
    			// return $extension;
    			if(strtolower($extension) != "csv") {
    				return redirect()->back()->with(['message'=> 'File is not csv please upload a csv file', 'style' => 'alert-danger']);
    			}
    			else {
    				$file->move("uploads/", "submission.csv");
    				$content = File::get("uploads/submission.csv");
    				$contentArray = explode("\n", $content);
    				$dataUpload = array();
    				$dataColumns = array();
    				array_shift($contentArray);
    				foreach ($contentArray as $contentSubArray) {
	    				$contentSubArray = explode("," ,$contentSubArray);
    					if(count($contentSubArray) == 6) {
	    					$dataColumns['parent_name'] = $contentSubArray[1]; 
	    					$dataColumns['student_name'] = $contentSubArray[2]; 
	    					$dataColumns['phone'] = $contentSubArray[3]; 
	    					$dataColumns['class'] = $contentSubArray[4]; 
	    					$dataColumns['email'] = $contentSubArray[5]; 
	    					$dataUpload[] = $dataColumns;
    						
    					}
    					// return $dataUpload;

    				}

    				// return var_dump($dataUpload);
    				$operationUpload  = DB::table("students")->insert($dataUpload);

    				if($operationUpload) {
    					return redirect()->back()->with(['message'=> 'Student Upload Successful', 'style' => 'alert-success']);
    				}
    			}
    		}
    	}
    }

    public function addStudentPage() {
    	return view('teacher-students-add');
    }

    public function addStudentAction(Request $request) {
    	$student = new Student;
    	$student->parent_name = $request->parent_name;
    	$student->student_name = $request->student_name;
    	$student->phone = $request->phone;
    	$student->email = $request->email;
    	$student->class = $request->class;

    	$isSaved = $student->save();

    	if ($isSaved) {
    		return redirect()->back()->with(['message'=> 'Student Info Successfully Added', 'style' => 'alert-success']);
    	}
    	else {
    		return redirect()->back()->with(['message'=> 'Ooops an error occured', 'style' => 'alert-danger']);
    	}
    }

    public function updateStudentPage($id) {
    	$student = Student::where("id", $id)->first();
    	return view('teacher-students-edit', compact('student'));
    }

    public function updateStudentAction(Request $request) {
    	$id = $request->id;
    	$student = Student::find($id);
    	$student->parent_name = $request->parent_name;
    	$student->student_name = $request->student_name;
    	$student->phone = $request->phone;
    	$student->email = $request->email;
    	$student->class = $request->class;

    	$isSaved = $student->save();

    	if ($isSaved) {
    		return redirect()->back()->with(['message'=> 'Student Info Successfully Updated', 'style' => 'alert-success']);
    	}
    	else {
    		return redirect()->back()->with(['message'=> 'Ooops an error occured', 'style' => 'alert-danger']);
    	}
    }
}