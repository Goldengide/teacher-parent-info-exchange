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
use App\Season;
use App\Subject;

class AdminController extends Controller
{
    //
    public function dashboard() {
    	$noOfStudents = Student::count();
    	$noOfTeachers = User::where('role', 'teacher')->count();



    	return view('pages.super-admin-dashboard', compact('noOfStudents', 'noOfTeachers'));
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
                            $dataColumns['password'] = bcrypt('lastname'); 
                            $dataColumns['phone'] = $contentSubArray[4]; 
                            $dataColumns['phone2'] = $contentSubArray[5]; 
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

    public function uploadStudentPage() {
    	return view('pages.super-admin-student-upload');
    }
    public function uploadStudentAction(Request $request) {}


    public function parents()  {
    	$parents = User::where('role', 'parent')->get();
    	$countParents = User::where('role', 'parent')->count();
        $currentSeason = Season::where('current', 1)->first();
        $activeSeason = Season::where('status', 1)->first();
    	return view('pages.super-admin-parent-list', compact('parents', 'countParents', 'currentSeason', 'activeSeason'));
    }

    public function teachers()  {     //done
    	$teachers = User::where('role', 'teacher')->get();
        $countTeachers = User::where('role', 'teacher')->count();
    	$classes = ClassTable::all();
        $currentSeason = Season::where('current', 1)->first();
        $activeSeason = Season::where('status', 1)->first();
    	return view('pages.super-admin-teacher-list', compact('teachers', 'countTeachers', 'currentSeason', 'activeSeason', 'classes'));
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
            return redirect()->back()->with(['message' => 'Operation Successful', 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message' => 'Operation Failed', 'style' => 'alert-danger']);
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
            return redirect()->back()->with(['message' => 'Operation Successful', 'style' => 'alert-success']);
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
                    $file->move("uploads/datas/", "student.csv");
                    $content = File::get("uploads/datas/student.csv");
                    $contentArray = explode("\n", $content);
                    $dataUpload = array();
                    $dataColumns = array();
                    array_shift($contentArray);
                    foreach ($contentArray as $contentSubArray) {
                        $contentSubArray = explode("," ,$contentSubArray);
                        if(count($contentSubArray) == 8) {
                            $dataColumns['parent_name'] = $contentSubArray[1]; 
                            $dataColumns['student_name'] = $contentSubArray[2]; 
                            $dataColumns['phone'] = $contentSubArray[5]; 
                            $dataColumns['phone2'] = $contentSubArray[6]; 
                            $dataColumns['entry_class_id'] = ClassTable::where('name', trim(strtolower($contentSubArray[3])))->value('id'); 
                            $dataColumns['class_id'] = ClassTable::where('name', trim(strtolower($contentSubArray[3])))->value('id'); 
                            $dataColumns['email'] = $contentSubArray[4]; 
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
        $class = ClassTable::where('id', $class_id)->first();
        return view('pages.super-admin-teacher-students-index', compact('students', 'class', 'countClasses'));
    }










    public function parentProfile($id) {
    	$parent = User::where('id', $id)->first();
    	return view('pages.super-admin-parent-view', compact('parent'));
    }

    public function teacherProfile($id) {
    	$teacher = User::where('id', $id)->first();
    	return view('pages.super-admin-teacher-profile', compact('teacher'));
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


    public function uploadResult($seasonId, $classId, $subjectId) {
        $season = Season::where('id', $seasonId)->first(); 
        $subject = Subject::where('id', $subjectId)->first(); 
        $class = ClassTable::where('id', $classId)->first(); 
        return view('pages.super-admin-result-upload', compact('subject', 'class', 'season'));
    }
}