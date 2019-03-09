<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ClassTable;
use App\Student;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
use App\User;
use App\Repository\DataRepository;
use App\Season;
use App\Result;
use App\Subject;
use App\StudentDetail;
use App\StudentSummary;
use App\ClassSummary;

class AdminController extends Controller
{

    //
    public function dashboard() {
    	$noOfStudents = Student::count();
    	$noOfTeachers = User::where('role', 'teacher')->count();
        $countClassSummary = ClassSummary::count();
        if($countClassSummary > 0) {
            $maxPerformance = ClassSummary::max('average_performance');
            $mostEffectiveTeacherClassId = ClassSummary::where('average_performance', $maxPerformance)->first()->class_id;
            $class = ClassTable::where('id', $mostEffectiveTeacherClassId)->first();
            $mostEffectiveTeacherId = $class->teacher_id;
            $mostEffectiveTeacher = User::where('id', $mostEffectiveTeacherId)->first();

        }
        else {
            $mostEffectiveTeacher = "";
        }


        // $findBestStudent = StudentSummary::where('')->get()
        // $bestStudnent = 



    	return view('pages.super-admin-dashboard', compact('noOfStudents', 'noOfTeachers', 'mostEffectiveTeacher'));
    }

    // public function index

    public function uploadTeachersPage() {  //done
    	return view('pages.super-admin-teacher-upload');
    }
    public function uploadTeachersAction(Request $request) {   //done
        $user = new User; 
        $role = 'teacher'; 
        $file = $request->file; 
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
                    $file->move("uploads/datas", "teacher.csv");
                    $content = File::get("uploads/datas/teacher.csv");
                    $contentArray = explode("\n", $content);
                    $dataUpload = array();
                    $dataColumns = array();
                    array_shift($contentArray);
                    foreach ($contentArray as $contentSubArray) {
                        $contentSubArray = explode("," ,$contentSubArray);
                        if(count($contentSubArray) == 8) {
                            $dataColumns['lastname'] = $contentSubArray[1]; 
                            $dataColumns['firstname'] = $contentSubArray[2]; 
                            $dataColumns['othernames'] = $contentSubArray[3]; 
                            $dataColumns['fullname'] = strtoupper($contentSubArray[1]). ", ". $contentSubArray[2]. " ". $contentSubArray[3]; 
                            $dataColumns['role'] = 'teacher'; 
                            // $dataColumns['password'] = bcrypt(trim(strtolower($contentSubArray[1]))); 
                            $dataColumns['password'] = bcrypt(trim(strtolower($contentSubArray[1]))); 
                            $dataColumns['phone'] = "0".$contentSubArray[4]; 
                            $dataColumns['phone2'] = "0".$contentSubArray[5]; 
                            $dataColumns['email'] = $contentSubArray[6]; 
                            $dataColumns['birthdate'] = $contentSubArray[7]; 
                            $dataUpload[] = $dataColumns;
                            
                        }

                        else {
                            return redirect()->back()->with(['message'=> 'Format not correct', 'style' => 'alert-danger']);
                            
                        }
                        // return $dataUpload;

                    }

                    // return var_dump($dataUpload);
                    $operationUpload  = DB::table("users")->insert($dataUpload);

                    if($operationUpload) {
                        return redirect()->back()->with(['message'=> 'Teacher Upload Successful', 'style' => 'alert-success']);
                    }
                }
            }
        }
    }


    public function parents()  {
        $currentSeasonExist = Season::where('current', 1)->where('status', 1)->count();
        if (!$currentSeasonExist) {
            return redirect('/super-admin/seasons')->with(['message' => 'You can only view Parent if you activate  and launch the Season', 'style' => 'alert-info']);
        }
        else {
        	$parents = User::where('role', 'parent')->get();
        	$countParents = User::where('role', 'parent')->count();
            $currentSeason = Season::where('current', 1)->first();
            $activeSeason = Season::where('status', 1)->first();
        	return view('pages.super-admin-parent-list', compact('parents', 'countParents', 'currentSeason', 'activeSeason'));
            }
    }

    public function teachers()  {     
    	$currentSeasonExist = Season::where('current', 1)->where('status', 1)->count();
        if (!$currentSeasonExist) {
            return redirect('/super-admin/seasons')->with(['message' => 'You can only view Parent if you activate  and launch the Season', 'style' => 'alert-info']);
        }
        else {

            $teachers = User::where('role', 'teacher')->get();
            $countTeachers = User::where('role', 'teacher')->count();
        	$classes = ClassTable::all();
            $currentSeason = Season::where('current', 1)->first();
            $activeSeason = Season::where('status', 1)->first();
        	return view('pages.super-admin-teacher-list', compact('teachers', 'countTeachers', 'currentSeason', 'activeSeason', 'classes'));
            
        }
    }




    public function classes() {
        $classes = ClassTable::all();
        return view('pages.super-admin-class-index', compact('classes'));
    }

    public function addClass() {
        $teachers = User::where('role', 'teacher')->get();
        return view('pages.super-admin-class-new', compact('teachers'));
    }

    public function addClassAction(Request $request) {
        $class = new ClassTable;
        $class->name = $request->name;
        $class->teacher_id = $request->teacher_id;
        $isSaved = $class->save();
        if ($isSaved) {
            return redirect()->back()->with(['message' => 'New Class Added Successful', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops! Something went wrong', 'style' => 'alert-danger']);
        }
    }

    public function editClass($id) {
        $class = ClassTable::where('id', $id)->first();
        $teachers = User::where('role', 'teacher')->get();
        return view('pages.super-admin-class-edit', compact('class', 'teachers'));
    }

    public function editClassAction(Request $request) {
        $id = $request->id;
        $class = ClassTable::find($id);
        $class->name = $request->name;
        $isSaved = $class->save();
        if ($isSaved) {
            return redirect()->back()->with(['message' => $class->name ." has been updated", 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Operation Failed', 'style' => 'alert-danger']);
        }
    }

    public function viewClass($id) {
        $class = ClassTable::where('id', $id)->first();
        $noOfStudents = Student::where('class_id', $class->id)->count();
        return view('pages.super-admin-class-view', compact('class', 'noOfStudents'));
    }

    public function assignClassTeacherPage($id) {
        $class = ClassTable::where('id', $id)->first();
        $teachers = User::where('role', 'teacher')->get();
        return view('pages.super-admin-class-assign-teacher', compact('class', 'teachers'));
    }

    public function assignClassTeacherAction(Request $request) {
        $id = $request->id;
        $class = ClassTable::find($id);
        $class->teacher_id = $request->teacher_id;
        $updateStudentDetails = DB::table('student_details')->where('class_id', $id)->update(['teacher_id' => $request->teacher_id]);
        $isSaved = $class->save();
        if ($isSaved) {
            return redirect()->back()->with(['message' => $class->teacher($class->teacher_id)->firstname.' has been assigned to Class '. strtoupper($class->name) , 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Operation Failed', 'style' => 'alert-danger']);
        }
    }

    public function classesUploadPage() {
        return view('pages.super-admin-class-upload');
    }

    public function classesUpload(Request $request) {
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
                    $file->move("uploads/datas", "classes.csv");
                    $content = File::get("uploads/datas/classes.csv");
                    $contentArray = explode("\n", $content);
                    $dataUpload = array();
                    $dataColumns = array();
                    array_shift($contentArray);
                    foreach ($contentArray as $contentSubArray) {
                        $contentSubArray = explode("," ,$contentSubArray);
                        if(count($contentSubArray) == 2) {
                            $dataColumns['name'] = trim(strtolower($contentSubArray[1])); 
                            $dataUpload[] = $dataColumns;
                            
                        }
                        else {
                            return redirect()->back()->with(['message'=> 'Format not correct', 'style' => 'alert-danger']);
                            
                        }

                    }

                    $operationUpload  = DB::table("class_tables")->insert($dataUpload);

                    if($operationUpload) {
                        return redirect()->back()->with(['message'=> 'Classes Upload Successful', 'style' => 'alert-success']);
                    }
                    else {
                        return redirect()->back()->with(['message'=> 'Classes Upload not Successful', 'style' => 'alert-danger']);
                    }
                }
            }
        }
    }





    
    public function addStudentPage() {
        $classes = ClassTable::all();
        return view('pages.super-admin-teacher-student-new', compact('classes'));
    }

    public function addStudentAction(Request $request) {
        $student = new Student;
        $student->parent_name = $request->parent_name;
        $student->student_name = $request->student_name;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->phone = $request->phone;
        $student->class_id = $request->class;
        $student->save();
        if ($student) {
            return redirect()->back()->with(['message' => "Student has been added", 'style' => "alert-success"]);
        }
        else {
            return redirect()->back()->with(['message' => "Ooops! Something went wrong", 'style' => "alert-danger"]);
        }
    }

    public function editStudentPage($id) {
        $student = Student::where('id', $id)->first();
        $classes = ClassTable::all();
        return view('pages.super-admin-teacher-student-edit', compact('student', 'classes'));
    }

    public function editStudentAction(Request $request) {
        $id = $request->id;
        $student = Student::find($id);
        $student->parent_name = $request->parent_name;
        $student->student_name = $request->student_name;
        $student->phone = $request->phone;
        $student->gender = $request->gender;
        $student->phone = $request->phone;
        $student->class_id = $request->class;
        $student->save();
        if ($student) {
            return redirect()->back()->with(['message' => "Student Info has been Updated", 'style' => "alert-success"]);
        }
        else {
            return redirect()->back()->with(['message' => "Ooops! Something went wrong", 'style' => "alert-danger"]);
        }
    }

    public function uploadStudentsPage() {
        return view('pages.super-admin-teacher-students-upload');
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
                    $file->move("uploads/datas/", "result.csv");
                    $content = File::get("uploads/datas/result.csv");
                    $contentArray = explode("\n", $content);
                    $dataUpload = array();
                    $dataColumns = array();
                    array_shift($contentArray);
                    foreach ($contentArray as $contentSubArray) {
                        $contentSubArray = explode("," ,$contentSubArray);
                        if(count($contentSubArray) == 9) {
                            $dataColumns['parent_name'] = $contentSubArray[1]; 
                            $dataColumns['birthday'] = $contentSubArray[8]; 
                            $dataColumns['student_name'] = $contentSubArray[2]; 
                            $dataColumns['phone'] = "0".$contentSubArray[6]; 
                            $dataColumns['phone2'] = "0".$contentSubArray[7]; 
                            $dataColumns['entry_class_id'] = ClassTable::where('name', trim(strtolower($contentSubArray[4])))->value('id'); 
                            $dataColumns['class_id'] = ClassTable::where('name', trim(strtolower($contentSubArray[4])))->value('id'); 
                            $dataColumns['email'] = $contentSubArray[5]; 
                            $dataColumns['gender'] = $contentSubArray[3]; 
                            $dataUpload[] = $dataColumns;
                            
                        }

                        else {
                            return redirect()->back()->with(['message'=> 'Format not correct', 'style' => 'alert-danger']);
                            
                        }
                        // return $dataUpload;

                    }

                    // return ($dataUpload);
                    $operationUpload  = DB::table("students")->insert($dataUpload);

                    if($operationUpload) {
                        return redirect()->back()->with(['message'=> 'Student Upload Successful', 'style' => 'alert-success']);
                    }
                }
            }
        }
    }


    public function students() {
        $countClasses = ClassTable::count(); 
        $students = Student::all();
        // return $students;
        return view('pages.super-admin-teacher-students-index', compact('students', 'countClasses'));
    }

    public function studentsByClass($classId) {
        $countClasses = ClassTable::count(); 
        $students = Student::where("class_id", $classId)->get();
        $class = ClassTable::where('id', $classId)->first();
        return view('pages.super-admin-teacher-students-index', compact('students', 'class', 'countClasses'));
    }

    public function graduatingStudents() {
        $countClasses = ClassTable::count(); 
        $students = Student::where("class_id", $classId)->get();
        $class = ClassTable::where('id', $class_id)->first();
        // get format and enter some name with some parent Id make sure that it well coded in a way it won't be discovered
    }

    public function newStudents() {
        // get format for this one too //when is that? it should be now
    }

    










    public function parentProfile($id) {
    	$parent = User::where('id', $id)->first();
        $countChildren = Student::where('parent_name', $parent->fullname)->count();
        $students = Student::where('parent_name', $parent->fullname)->get();
        
    	return view('pages.super-admin-parent-profile', compact('parent', 'countChildren', 'students'));
    }

    public function teacherProfile($id) {
    	$teacher = User::where('id', $id)->first();
        $class = ClassTable::where('teacher_id', $teacher->id)->first();
    	return view('pages.super-admin-teacher-profile', compact('teacher', 'class'));
    }

    public function studentProfile($id) {
        $student = Student::where('id', $id)->first();
        $season = Season::where('current', true)->first();
        $processedResult = StudentSummary::where('class_id', $student->class_id)->where('season_id', $season->id)->count();
        if($processedResult > 0) {
            $isProcessedResult = true;
        }
        else {
            $isProcessedResult = false;
        }
        return view('pages.super-admin-teacher-students-profile', compact('student', 'isProcessedResult', 'season'));
    }

    
    public function updateParentPage($id) {
    	$teacher = User::where('id', $id)->first();
    	return view('pages.super-admin-parent-update', compact('parent'));
    }
    public function updateParentAction(Request $request) {
    	$id = $request->id;
    	$user = User::find($id);
    	$user->firstname = $request->firstname;
    	$user->lastname = $request->lastname;
    	$user->role = 'parent';
    	$user->othernames = $request->othernames;
    	$user->email = $request->email;
    	$user->phone = $request->phone;
    	// $user->phone2 = $request->phone2;
    	$isSaved = $user->save();
    	if($isSaved) {
    		return redirect()->back()->with(['message'=> 'Parent Update Successful', 'style' => 'alert-success']);
    	}
    	else {
    		return redirect()->back()->with(['message'=> 'Ooops an error occured', 'style' => 'alert-danger']);
    	}


    }

    public function updateTeacherPage($id) {
    	$teacher = User::where('id', $id)->first();
    	return view('pages.super-admin-teacher-edit', compact('teacher'));
    }
    public function updateTeacherAction(Request $request) {
    	$id = $request->id;
    	$user = User::find($id);
    	$user->firstname = $request->firstname;
    	$user->lastname = $request->lastname;
    	$user->othernames = $request->othernames;
    	$user->email = $request->email;
    	$user->phone = $request->phone;
    	// $user->phone2 = $request->phone2;
    	$isSaved = $user->save();
    	if($isSaved) {
    		return redirect()->back()->with(['message'=> 'Teacher Update Successful', 'style' => 'alert-success']);
    	}
    	else {
    		return redirect()->back()->with(['message'=> 'Ooops an error occured', 'style' => 'alert-danger']);
    	}


    }

    public function newTeacherPage() {
    	return view('pages.super-admin-teacher-new');
    }
    public function newTecherAction(Request $request) {
    	$user = new User;
    	$user->firstname = $request->firstname;
    	$user->lastname = $request->lastname;
    	$user->role = 'teacher';
    	$user->othernames = $request->othernames;
    	$user->email = $request->email;
    	$user->phone = $request->phone;
    	$user->phone2 = $request->phone2;
    	$isSaved = $user->save();
    	if($isSaved) {
    		return redirect()->back()->with(['message'=> 'Teacher Added Successful', 'style' => 'alert-success']);
    	}
    	else {
    		return redirect()->back()->with(['message'=> 'Ooops an error occured', 'style' => 'alert-danger']);
    	}


    }


    public function newParentPage() {
    	return view('pages.super-admin-parent-new');
    }
    public function newParentAction(Request $request) {
    	$user = new User;
    	$user->firstname = $request->firstname;
    	$user->lastname = $request->lastname;
    	$user->role = 'parent';
    	$user->othernames = $request->othernames;
    	$user->email = $request->email;
    	$user->phone = $request->phone;
    	$user->phone2 = $request->phone2;
    	$isSaved = $user->save();
    	if($isSaved) {
    		return redirect()->back()->with(['message'=> 'Teacher Update Successful', 'style' => 'alert-success']);
    	}
    	else {
    		return redirect()->back()->with(['message'=> 'Ooops an error occured', 'style' => 'alert-danger']);
    	}


    }

    public function extractParent() {
        $students = Student::all();
        $logs = "";
        $logFile = public_path('uploads\log.txt');
        // return $logFile;

        foreach ($students as $student) {
            $userPresent = User::where('phone', $student->phone)->count();

            if($userPresent == 0) {
                DB::table('users')->insert(['fullname' => $student->parent_name, 'phone' => $student->phone, 'phone2' => $student->phone2, 'email' => $student->email, 'password' => bcrypt($student->phone), 'role' => 'parent']);
            }

            else {
                $logs .= "- ".$student->parent_name. " was already uploaded  \n";
                if($handle = fopen($logFile, 'w+')) {
                        (fwrite($handle, $logs));

                }
            }
        }

        return redirect()->back()->with(['message' => "Parent info Successfully extracted", 'style' => 'alert-success']);
    }






    public function subjects() {
        $subjects = Subject::all();
        return view('pages.super-admin-subject-index', compact('subjects'));
    }



    public function uploadSubjectsPage () {
        return view('pages.super-admin-subject-upload');
    }

    public function uploadSubjects(Request $request) {

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
                    $file->move("uploads/datas", "subject.csv");
                    $content = File::get("uploads/datas/subject.csv");
                    $contentArray = explode("\n", $content);
                    $dataUpload = array();
                    $dataColumns = array();
                    array_shift($contentArray);
                    foreach ($contentArray as $contentSubArray) {
                        $contentSubArray = explode("," ,$contentSubArray);
                        if(count($contentSubArray) == 3) {

                            $dataColumns['name'] = $contentSubArray[1]; 
                            $dataColumns['short_name'] = $contentSubArray[2]; 
                            $dataUpload[] = $dataColumns;
                            
                        }

                        else {
                            return redirect()->back()->with(['message'=> 'Format not correct', 'style' => 'alert-danger']);
                            
                        }

                    }

                    $operationUpload  = DB::table("subjects")->insert($dataUpload);

                    if($operationUpload) {
                        return redirect()->back()->with(['message'=> 'Subjects Upload Successful', 'style' => 'alert-success']);
                    }
                    else {
                        return redirect()->back()->with(['message'=> 'Upload not Successful', 'style' => 'alert-danger']);
                    }
                }
            }
        }
    }

    public function addSubjectPage(){
        return view('pages.super-admin-subject-new');
    }

    public function addSubjectAction(Request $request){
        $subject = new Subject;
        $subject->name = $request->name;
        $subject->short_name = $request->short_name;
        $subject->save();

        if ($subject) {
            return redirect()->back()->with(['message' => 'Subject Successfully Added', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }
    }

    public function editSubjectPage($id){
        $subject = Subject::where('id', $id)->first();
        return view('pages.super-admin-subject-edit', compact('subject'));
    }
    public function editSubjectAction(Request $request){
        $id = $request->id;
        $subject = Subject::find($id);
        $subject->name = $request->name;
        $subject->short_name = $request->short_name;
        $subject->save();

        if ($subject) {
            return redirect()->back()->with(['message' => 'Subject Successfully Updated', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }
    }




    public function classForResult($seasonId) {
        $season = Season::where('id', $seasonId)->first();
        $classes = ClassTable::all();
        $results = true;
        return view('pages.super-admin-class-index', compact('classes', 'season', 'results'));
    }

    public function convertObjectArraytoCasualArray() {

    }

    public function subjectsForResult($seasonId, $classId) {
        $subjects = Subject::all();
        $season = Season::where('id', $seasonId)->first();
        $class = ClassTable::where('id', $classId)->first();
        $results = true;
        $check1 = StudentDetail::orderBy('subject_id')->pluck('subject_id')->unique()->values()->all();
        $check2 = Result::orderBy('subject_id')->pluck('subject_id')->unique()->values()->all();
        // return $check1;
        $overallSubjects = count($check1);
        $uploadedSubjectsResult = count($check2);

        $processedResult = StudentSummary::where('class_id', $classId)->where('season_id', $seasonId)->count();
        if($processedResult > 0) {
            $isProcessedResult = true;
        }
        else {
            $isProcessedResult = false;
        }

        if ($overallSubjects == $uploadedSubjectsResult) {
            $isAllResultsHasBeenUploadedForEachStudent = 1;
        }
        else {
            $isAllResultsHasBeenUploadedForEachStudent = 0;
        }
        // return $isAllResultsHasBeenUploadedForEachStudent;

        return view('pages.super-admin-subject-index', compact('subjects', 'class', 'season', 'results', 'isAllResultsHasBeenUploadedForEachStudent', 'overallSubjects', 'uploadedSubjectsResult', 'isProcessedResult'));
    }

    public function resultIndex($seasonId, $classId, $subjectId) {
        $subject = Subject::where('id', $subjectId)->first();
        // return $subject;
        $class = ClassTable::where('id', $classId)->first();
        $season = Season::where('id', $seasonId)->first();
        $resultObject = Result::where('season_id', $seasonId)->where('class_id', $classId)->where('subject_id', $subjectId);
        $results = $resultObject->get();
        $resultInfo = $resultObject->first();
        $resultSumAssessment = $resultObject->sum('assessment');
        $resultSumExam = $resultObject->sum('exam_score');
        $resultCount = $resultObject->count();
        $resultAverage = ($resultSumAssessment + $resultSumExam)/$resultCount;
        $resultAverage = round($resultAverage);
        return view('pages.super-admin-result-index', compact('results', 'subject', 'class', 'season', 'resultAverage', 'resultInfo'));
    }

    public function resultSummary() {

    }

    public function bestStudents() {

    }

    public function viewStudentResult($seasonId, $classId, $studentId) {
        $student = Student::where('id', $studentId)->first();
        $studentSummary = StudentSummary::where('season_id', $seasonId)
                                        ->where('class_id', $classId)
                                        ->where('student_id', $studentId)
                                        ->first();
        $results =  Result::where('season_id', $seasonId)
                                ->where('class_id', $classId)
                                ->where('student_id', $studentId)
                                ->get();

        return view('pages.super-admin-result-student-index', compact('results', 'studentSummary', 'student'));

    }

    public function uploadResult($seasonId, $classId, $subjectId) {
        $season = Season::where('id', $seasonId)->first(); 
        $subject = Subject::where('id', $subjectId)->first(); 
        $class = ClassTable::where('id', $classId)->first(); 
        return view('pages.super-admin-result-upload', compact('subject', 'class', 'season'));
    }






    public function uploadResultAction(Request $request) {

        $seasonId = $request->season_id;
        $subjectId = $request->subject_id;
        // $studentId = $request->student_id;
        $classId = $request->class_id;

        $class = ClassTable::where('id', $classId)->first();
        $subject = Subject::where('id', $subjectId)->first();
        $season = Subject::where('id', $seasonId)->first();
        $dataRepository = new DataRepository;
        $generatedfilename = "admin_".$dataRepository->replaceDelimeter($season->session, "/", "_");
        $generatedfilename .= "_Term_".$season->term_no."_";
        $generatedfilename .= $class->name."_".$subject->name."_"."results.csv";
        // return $generatedfilename;

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
                    $file->move("uploads/datas", $generatedfilename);
                    $content = File::get("uploads/datas/".$generatedfilename);
                    $contentArray = explode("\n", $content);
                    $dataUpload = array();
                    $dataColumns = array();
                    array_shift($contentArray);
                    foreach ($contentArray as $contentSubArray) {
                        $contentSubArray = explode("," ,$contentSubArray);
                        if(count($contentSubArray) == 5) {

                            $dataColumns['season_id'] = $seasonId; 
                            $dataColumns['subject_id'] = $subjectId; 
                            $dataColumns['class_id'] = $classId; 
                            $dataColumns['teacher_id'] = $class->teaacher_id; 
                            $dataColumns['student_id'] = $contentSubArray[2]; 
                            $dataColumns['assessment'] = $contentSubArray[3]; 
                            $dataColumns['exam'] = $contentSubArray[4]; 
                            $dataUpload[] = $dataColumns;
                            
                        }

                        else {
                            return redirect()->back()->with(['message'=> 'Format not correct!', 'style' => 'alert-danger']);
                            
                        }

                    }

                    $operationUpload  = DB::table("results")->insert($dataUpload);

                    if($operationUpload) {
                        return redirect()->back()->with(['message'=> 'Result Upload Successful', 'style' => 'alert-success']);
                    }
                    else {
                        return redirect()->back()->with(['message'=> 'Ooops! Upload not Successful', 'style' => 'alert-danger']);
                    }
                }
            }
        }
    }





    public function seasonforResult() {
        $seasons = Season::all();
        $currentSeason = Season::where('current', true);
        $results = true;
        $activeSession = 0;
        $activeTerm = 0;
        return view('pages.super-admin-seasons-index', compact('seasons', 'currentSeason', 'results', 'activeSession', 'activeTerm'));
    }

    



    public function viewResult($id) {
        $result = Result::where('id', $id)->first();
        return view('pages.super-admin-result-view', compact('result'));
    }

    public function editResult($id) {
        $result = Result::where('id', $id)->first();
        return view('pages.super-admin-result-edit', compact('result'));

    }

    public function editResultAction(Request $request) {
        $result = Result::find($id);
        $result->assessment = $request->assessment;
        $result->exam = $request->exam;
        $result->save();


        if ($result) {
            return redirect()->back()->with(['message' => 'Result Successfully Updated', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }

    }

    public function approveResult(Request $request) {
        $seasonId = $request->season_id;
        $classId = $request->class_id;
        $subjectId = $request->subject_id;
        $seasonId = $request->season_id;

        $subject = Subject::where('id', $subjectId)->first();
        // return $subject;
        $class = ClassTable::where('id', $classId)->first();
        $season = Season::where('id', $seasonId)->first();
        $resultObject = Result::where('season_id', $seasonId)->where('class_id', $classId)->where('subject_id', $subjectId);
        $results = $resultObject->get();
        $resultBest = $resultObject->max('total');
        $resultLow = $resultObject->min('total');
        $resultSum = $resultObject->sum('total');
        $resultCount = $resultObject->count();
        $resultAverage = $resultSum / $resultCount;
        $resultAverage = round($resultAverage);

        $classSummary = new ClassSummary;
        $classSummary->class_id = $classId;
        $classSummary->subject_id = $subjectId;
        $classSummary->season_id = $seasonId;
        $classSummary->best_performance = $resultBest;
        $classSummary->lowest_performance = $resultLow;
        $classSummary->average_performance = $resultAverage;
        // $classSummary->comment = "resultAverage";
        $isSaved = $classSummary->save();

        $resultApprove = $resultObject->update(['approved' => 1]);


        if ($isSaved) {
            return redirect()->back()->with(['message' => 'Result Successfully Approved', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }


    }


    public function summaryStudentResult(Request $request) {
        $studentObject = Result::where('season_id', $seasonId)
                            ->where('class_id', $classId);
        $bestResult = $studentObject->where('student_id', $studentId);
        $studentSummary= new StudentSummary;
        $studentSummary->class_id = $classId;
        $studentSummary->student_id = $studentId;
        $studentSummary->season_id = $season_id;
        $studentSummary->overall_percentage = $bestResult->sum('total')/$bestResult->count() * 100;
        $studentSummary->best_score = $bestResult->max('total');
        $studentSummary->worst_score = $bestResult->min('total');
        $isSaved = $studentSummary->save();

        if ($isSaved) {
            return redirect()->back()->with(['message' => 'Result Successfully Approved', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }
    }
    // public function getStudentsResults($studentId) {
    //     // $result = 
    // }

    public function processStudentResult(Request $request) {
        $insertArray = array();
        $studentCount = Student::where('class_id', $request->class_id)->count();
        $studentResults = Result::where('season_id', $request->season_id)
                                ->where('class_id', $request->class_id)
                                ->orderBy('subject_id', 'class_id', 'student_id')
                                ->take($studentCount)
                                ->get();
        foreach ($studentResults as $studentResult) {
            $insertArray[] =  $studentResult->summary($request->season_id, $request->class_id, $studentResult->student_id);
        }
        $operation = DB::table('student_summaries')->insert($insertArray);

        if ($operation) {
            return redirect()->back()->with(['message' => 'Result Successfully Processed', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }



    }
    public function processEachStudentResult(Request $request) {
        $studentObject = Result::where('season_id', $request->season_id)
                            ->where('class_id', $request->class_id)
                            ->where('student_id', $student->id);
        $students = Student::where('class_id', $request->class_id)->get();
        
        $operation = DB::table('student_summaries')
                        ->insert([
                            'class_id' => $request->class_id,
                            'season_id' => $request->season_id,
                            'student_id' => $request->student_id,
                            'percentage' => $studentObject->sum('total')/$studentObject->count(),
                            'best_score' => $studentObject->max('total'),
                            'worse_score' => $studentObject->min('total')
                        ]);
            
        

        if ($operation) {
            return redirect()->back()->with(['message' => 'Result Successfully Processed', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Ooops Something went wrong', 'style' => 'alert-danger']);
        }
    }



    public function assignTeacherClassPage($id) {
        $teacher = User::where('id', $id)->first();
        $classes = ClassTable::all();
        return view('pages.super-admin-teacher-assign-class', compact('classes', 'teacher'));
    }
    public function assignTeacherClassAction(Request $request) {
        $teacherId = $request->id;

        $class = ClassTable::find($request->class_id);
        $class->teacher_id = $teacherId;
        $updateStudentDetails = DB::table('student_details')->where('class_id', $request->class_id)->update(['teacher_id' => $request->teacherId]);
        $isSaved = $class->save();
        if ($isSaved) {
            return redirect()->back()->with(['message' => $class->teacher($teacherId)->firstname.' has been assigned to Class '. strtoupper($class->name) , 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Operation Failed', 'style' => 'alert-danger']);
        }
    }

    public function subjectIndex() {
        $subjects = Subject::all();
        $season = Season::where('current', 1)->first();
        $class = ClassTable::where('teacher_id', Auth::user()->id)->first();
        $subject = Subject::where('id', 10)->first();
        // return $subject->result($class->id, $subject->id, $season->id);
        return view('pages.teacher-subjects-index', compact('subjects', 'class', 'season'));
    }







}

