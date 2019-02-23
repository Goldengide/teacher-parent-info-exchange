<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ClassTable;
use App\Student;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
use App\Subject;
use App\Season;
use App\Result;

class TeacherController extends Controller
{
    //

    public function dashboard() {
    	$class = ClassTable::where('teacher_id', Auth::user()->id)->first();
    	$noOfStudents = Student::where('class_id', $class->id)->count();

    	$noOfSubjects = 15;
    	return view('pages.teacher-dashboard', compact('noOfStudents', 'noOfSubjects'));
    }

    

    public function students() {
    	$students = Student::all();
    }

    public function studentsByClass() {
    	$class = ClassTable::where('teacher_id', Auth::user()->id)->first();
    	$students = Student::where("class_id", $class->id)->get();
    	return view('pages.teacher-students-index', compact('students', 'class'));
    }
    

    public function uploadStudentsPage() {
    	return view('pages.teacher-upload-students-info');
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
                            $dataColumns['entry_class'] = $contentSubArray[4]; 
	    					$dataColumns['class_id'] = ClassTable::where('name', $contentSubArray[4])->value('id'); 
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

    public function seperateAttachedParentNumbers() {
        $parents = User::where('role', 'parent')->get();
        $count = 0;
        foreach ($parents as $parent) {
            if(strstr($parent, ",")) {
                $count++;
            }
        }

        return $count;
    }
    public function downloadResultTemplate() {
        $subjectId = $request->subject_id;
        // $template = "";
        // $
        // when the use has uploaded, a file is created called subjectName_ClassName_result
        // result table will have to contain string for usage purpose too
    }

    public function uploadResultPage($subjectId) {
        $class = ClassTable::where('teacher_id', Auth::user()->id)->value('name');
        $subject = ClassTable::where('id', $subjectId)->value('name');
        // $seasons = Season::
        return view('pages.teacher-upload-results-for-subject', compact('class', 'subject'));
    }
    public function uploadResultAction(Request $request) {
        $subject = $request->subject;
        $class = $request->class;
        $subjectId = $request->subject_id;
        $teacherId = $request->teacher_id;
        $seasonId = $request->season_id;
        $classId = $request->class_id;
        $seasonId = $request->season_id;
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
                        if(count($contentSubArray) == 5) {
                            $dataColumns['student_name'] = $contentSubArray[1]; 
                            $dataColumns['subject_id'] = $subjectId; 
                            $dataColumns['season_id'] = $seasonId; 
                            $dataColumns['class_id'] = $classId; 
                            $dataColumns['teacher_id'] = $teacherId; 
                            $dataColumns['assessment'] = $contentSubArray[3]; 
                            $dataColumns['exam_score'] = $contentSubArray[4]; 
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

    public function prepareResult() {}

    public function addStudentPage() {
    	return view('pages.teacher-students-add');
    }

    public function addStudentAction(Request $request) {
    	$student = new Student;
    	$student->parent_name = $request->parent_name;
    	$student->student_name = $request->student_name;
    	$student->phone = $request->phone;
    	$student->email = $request->email;
        $student->entry_class = $request->class;
    	$student->class_id = $request->class_id;

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
    	return view('pages.teacher-students-edit', compact('student'));
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