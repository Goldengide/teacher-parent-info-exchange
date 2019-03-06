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
use App\User;
use App\Season;
use App\Result;
use App\StudentDetail;
use App\Repository\DataRepository;

class TeacherController extends Controller
{
    //

    public function dashboard() {
        $currentSeason = Season::where('current', true)->first();
        $classHasTeacher = ClassTable::where('teacher_id', Auth::user()->id)->count();
        if($classHasTeacher) {
            $class = ClassTable::where('teacher_id', Auth::user()->id)->first();

            $sampleStudentId = StudentDetail::where('class_id', $class->id)
                                ->where('season_id', $currentSeason->id)
                                ->first()->id;
            $class = ClassTable::where('teacher_id', Auth::user()->id)->first();
            $noOfStudents = Student::where('class_id', $class->id)->count();
            $noOfSubjects = StudentDetail::where('class_id', $class->id)
                            ->where('season_id', $currentSeason->id)
                            ->where('student_id', $sampleStudentId)
                            ->count();
        }
        else {
            $message = "You have not been assigned to a class yet. See the Administrator";
            $noOfStudents = 0;
            $noOfSubjects = 0;
        }
        // $class == 0 true fasl

    	return view('pages.teacher-dashboard', compact('noOfStudents', 'noOfSubjects'));
    }


    public function students() {
    	$students = Student::all();
    }

    public function studentsByClass() {
    	$class = ClassTable::where('teacher_id', Auth::user()->id)->first();
        // WE have to catch errors for Teachers that have not been assigned
    	$students = Student::where("class_id", $class->id)->get();
    	return view('pages.teacher-students-index', compact('students', 'class'));
    }
    

    public function uploadStudentsPage() {
    	return view('pages.teacher-upload-students-info');
    }

    public function uploadStudentsAction(Request $request) {
        $teacherId = Auth::user()->id;
        $class = ClassTable::where('teacher_id', $teacherId)->first();
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
    					if(count($contentSubArray) == 7) {
	    					$dataColumns['parent_name'] = $contentSubArray[1]; 
	    					$dataColumns['student_name'] = $contentSubArray[2]; 
                            $dataColumns['gender'] = $contentSubArray[3]; 
	    					$dataColumns['email'] = $contentSubArray[4];
                            $dataColumns['phone'] = $contentSubArray[5]; 
                            $dataColumns['phone2'] = $contentSubArray[6]; 
                            $dataColumns['birthday'] = $contentSubArray[7]; 
                            $dataColumns['entry_class_id'] = $class->id; 
                            $dataColumns['class_id'] = $class->id; 
	    					$dataUpload[] = $dataColumns;
    						
    					}

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

    public function uploadResultPage($subjectId) {
        $class = ClassTable::where('teacher_id', Auth::user()->id)->value('name');
        $subject = ClassTable::where('id', $subjectId)->value('name');
        // $seasons = Season::
        return view('pages.teacher-upload-results-for-subject', compact('class', 'subject'));
    }
    

    public function prepareResult() {}

    public function addStudentPage() {
        $classes = ClassTable::all();
    	return view('pages.teacher-students-add', compact('classes'));
    }

    public function addStudentAction(Request $request) {
    	$student = new Student;
    	$student->parent_name = $request->parent_name;
    	$student->student_name = $request->student_name;
    	$student->phone = $request->phone;
    	$student->email = $request->email;
        $student->entry_class_id = $request->class_id;
    	$student->class_id = $request->class_id;

    	$isSaved = $student->save();

    	if ($isSaved) {
            $season = Season::where('current', true)->first();
            $subjects = Subject::all();
            $classes = ClassTable::all();
            $studentDetails = array();
            $eachDetails = array();
            foreach ($subjects as $subject) {
                    $eachDetails['teacher_id'] = 0;     // we can decide to retain teacher thus choosing class and populating them with teacher_id both in student details and classTables. 
                    $eachDetails['subject_id'] = $subject->id;
                    $eachDetails['class_id'] = $student->class_id;
                    $eachDetails['student_id'] = $student->id;
                    $eachDetails['season_id'] = $season->id;
                    $studentDetails[] = $eachDetails;
            }
            DB::table('student_details')->insert($studentDetails);
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

    	$isSaved = $student->save();

    	if ($isSaved) {
    		return redirect()->back()->with(['message'=> 'Student Info Successfully Updated', 'style' => 'alert-success']);
    	}
    	else {
    		return redirect()->back()->with(['message'=> 'Ooops an error occured', 'style' => 'alert-danger']);
    	}
    }


    public function viewStudent($id) {
        $student = Student::where('id', $id)->first();
        // $noOfStudents = Student::where('class_id', $class->id)->count();     // $lastSemesterPerformance;
        return view('pages.teacher-students-profile', compact('student'));
    }


    public function parents() {
        // weneedto adjust this code to be able to display parent due to class
        $parents = User::where('role', 'parent')->get();
        return view('pages.teacher-parent-index', compact('parents'));
    }

    public function viewParent($parentId) {
        $parent = User::where('id', $parentId)->first();
        $countChildren = Student::where('parent_name', $parent->fullname)->count();
        $students = Student::where('parent_name', $parent->fullname)->get();
        return view('pages.teacher-parent-profile', compact('parent', 'countChildren', 'students'));
    }






    public function sessionIndex() {
        $thereIsPastSeasons = Season::where('ended', 1)->count();
        if (!$thereIsPastSeasons) {
            return redirect('/teacher/subjects');
        }
        else {
            $pastSeasons = Season::where('ended', 1)->get();
            return view('pages.teacher-result-session', compact('pastSeasons'));
        }

    }

    public function subjectIndex() {
        $subjects = Subject::all();
        $season = Season::where('current', 1)->first();
        $class = ClassTable::where('teacher_id', Auth::user()->id)->first();
        // return $subject->result($class->id, $subject->id, $season->id);
        return view('pages.teacher-subjects-index', compact('subjects', 'class', 'season'));
    }

    public function uploadResult($seasonId, $classId, $subjectId) {
        $season = Season::where('id', $seasonId)->first(); 
        $subject = Subject::where('id', $subjectId)->first(); 
        $class = ClassTable::where('id', $classId)->first(); 
        return view('pages.teacher-result-upload', compact('subject', 'class', 'season'));
    }

    public function uploadResultAction(Request $request) {
        $subjectId = $request->subject_id;
        $teacherId = $request->teacher_id;
        $seasonId = $request->season_id;
        $classId = $request->class_id;
        $seasonId = $request->season_id;
        $file = $request->file('file');
        $class = ClassTable::where('id', $classId)->first();
        $subjectName = Subject::where('id', $subjectId)->first();
        $season = Season::where('id', $seasonId)->first();
        $dataRepository = new DataRepository;
        $generatedfilename = $dataRepository->replaceDelimeter($season->session, "/", "_");
        $generatedfilename .= "_".$dataRepository->sequenceNumber($season->term_no). "_Term_";
        $generatedfilename .= $class->name."_".$subjectName."_"."results.csv";

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
                    $ResultHasBeenUploadedPreviously = Result::where('subject_id', $subjectId)->where('class_id', $classId)->where('season_id', $seasonId)->count();
                    if(!$ResultHasBeenUploadedPreviously) {
                        $times_uploaded = 1;
                    }
                    else {
                        $times_uploaded = Result::where('subject_id', $subjectId)->where('class_id', $classId)->where('season_id', $seasonId)->first()->times_uploaded + 1;
                        Result::where('subject_id', $subjectId)->where('class_id', $classId)->where('season_id', $seasonId)->delete();
                    }
                    $resultFileName = 
                    $file->move("uploads/datas/", "generatedfilename.csv");
                    $content = File::get("uploads/datas/generatedfilename.csv");
                    $contentArray = explode("\n", $content);
                    $dataUpload = array();
                    $dataColumns = array();
                    array_shift($contentArray);
                    foreach ($contentArray as $contentSubArray) {
                        $contentSubArray = explode("," ,$contentSubArray);
                        if(count($contentSubArray) == 5) {
                            $dataColumns['student_id'] = $contentSubArray[2]; 
                            $dataColumns['subject_id'] = $subjectId; 
                            $dataColumns['season_id'] = $seasonId; 
                            $dataColumns['class_id'] = $classId; 
                            $dataColumns['teacher_id'] = $class->teacher_id; 
                            $dataColumns['assessment'] = $contentSubArray[3]; 
                            $dataColumns['exam_score'] = $contentSubArray[4]; 
                            $dataColumns['times_uploaded'] = $times_uploaded; 
                            $dataUpload[] = $dataColumns;
                            
                        }
                        else{
                            return redirect()->back()->with(['message'=> 'Format not correct', 'style' => 'alert-danger']);
                        }
                        // return $dataUpload;

                    }

                    // return var_dump($dataUpload);
                    $operationUpload  = DB::table("results")->insert($dataUpload);

                    if($operationUpload) {
                        return redirect('/teacher/subjects')->with(['message'=> 'Result has been uploaded Successful', 'style' => 'alert-success']);
                    }
                    else {
                        return redirect('/teacher/subjects')->with(['message'=> 'Ooops! An Error Occured', 'style' => 'alert-danger']);

                    }
                }
            }
        }
    }


    public function resultIndex($seasonId, $classId, $subjectId) {
        $subject = Subject::where('id', $subjectId)->first();
        $class = ClassTable::where('id', $classId)->first();
        $results = Result::where('season_id', $seasonId)->where('class_id', $classId)->where('subject_id', $subjectId)->get();
        return view('pages.teacher-result-index', compact('results', 'subject', 'class'));
    }

    public function viewResult($id) {
        $result = Result::where('id', $id)->first();
        return view('pages.teacher-result-view', compact('result'));
    }

    public function editResult($id) {
        $result = Result::where('id', $id)->first();
        return view('pages.teacher-result-edit', compact('result'));

    }

    public function viewResultForStudent($id, $seasonId) {
        $student = Student::where('id', $id)->first();
        $results = Result::where('student_id', $id)->where('season_id', $seasonId)->get();
        return view('pages.teacher-students-result-index', compact('results', 'student'));
    }


    public function editResultAction(Request $request) {
        $id = $request->id;
        $result = Result::find($id);
        $result->assessment = $request->assessment;
        $result->exam_score = $request->exam_score;
        $result->save();


        if ($result) {
            return redirect()->back()->with(['message' => 'Result Successfully Updated', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }

    }

    
}