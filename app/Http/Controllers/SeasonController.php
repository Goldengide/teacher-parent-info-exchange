<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Season;
use App\Subject;
use App\Student;
use App\ClassTable;
use App\User;
use App\StudentDetail;

class SeasonController extends Controller
{
    //
    public function index() {
    	$seasons = Season::all();
    	$activeSession  = "unset";
    	$activeTerm  = "unset";
        $noOfStudent = Student::count();
        $noOfClass = ClassTable::count();
        $noOfSubject = Subject::count();
	    $activeSeason = Season::where('status', 1)->first();
    	if(isset($activeSeason)) {
	    	$activeSession = $activeSeason->session;
	    	$activeTerm = $activeSeason->term_no;
	    	if($activeTerm == 1) {$activeTerm = '1'."<sup>st</sup>";}
	    	if($activeTerm == 2) {$activeTerm = '2'."<sup>nd</sup>";}
	    	if($activeTerm == 3) {$activeTerm = '3'."<sup>rd</sup>";}
    	}
    	return view('pages.super-admin-seasons-index', compact('seasons', 'activeTerm', 'activeSession', 'noOfSubject', 'noOfClass', 'noOfStudent'));
    }

    public function addPage() {}
    public function addAction(Request $request) {}
    public function edit($id) {}
    public function update(Request $request) {}
    public function clearSeasons() {
    	$operationClear = DB::table('seasons')->delete();
    	if ($operationClear) {
    		return "Successfully deleted";
    	}
    }

    public function generateSeasonsFromIntervals($start, $stop) {
    	$dataUpload = array();
    	$dataColumns = array();
    	$seasons =  range($start, $stop);
    	$terms = array(1,2,3);

    	foreach ($seasons as $season) {
    		$neighbour = $season+1;
    		$session = $season. "/". $neighbour;
    		
    		foreach ($terms as $term) {
    			$dataColumns['term_no'] = $term;
    			$dataColumns['session'] = $session;
    			$dataUpload[] = $dataColumns;
    		}
    	}

    	// return $dataUpload;

    	$operationUpload  = DB::table("seasons")->insert($dataUpload);

    	if($operationUpload) {
    		return redirect()->back()->with(['message'=> 'Seasons Generation Successful', 'style' => 'alert-success']);
    	}
    }

    public function generateSeasonsInterface() {
    	return view('seasons-generate-page');
    }

    public function generateSeasonsAction(Request $request) {

    }

    public function launchSeason($id) {  // put option start season in front and make sure ended Season doesn't have it

        $season = Season::where('id', $id)->first();
        $subjects = Subject::all();
        $classes = ClassTable::all();
        $students = Student::all();
        $studentDetails = array();
        $eachDetails = array();
        foreach ($subjects as $subject) {
            foreach ($students as $student) {
                $eachDetails['teacher_id'] = 0;     // we can decide to retain teacher thus choosing class and populating them with teacher_id both in student details and classTables. 
                $eachDetails['subject_id'] = $subject->id;
                $eachDetails['class_id'] = $student->class_id;
                $eachDetails['student_id'] = $student->id;
                $eachDetails['season_id'] = $id;
                $studentDetails[] = $eachDetails;
            }
        }
        $resetSeasons = DB::table('seasons')->update(['current' => 0]);
        $activateSeason = DB::table('seasons')->where('id', $id)->update(['current' => 1]);
        $operationPopulate = DB::table('student_details')->insert($studentDetails);

        if ($season->term == 1) { $season->term == "1<sup>st</sup>"; }
        if ($season->term == 2) { $season->term == "2<sup>nd</sup>"; }
        if ($season->term == 3) { $season->term == "3<sup>rd</sup>"; }


        $seasonMessage = "The ".$season->term." term of ". $season->session. " Session has been opened";


        if($operationPopulate) {
            return redirect()->back()->with(['message'=> $seasonMessage, 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message'=> "Ooops!!  Something Happened", 'style' => 'alert-danger']);
        }
    }

    public function launchNewSeason() { 
        // Find out how to ping a url using a laravel php command 
        $season = Season::where('id', $id)->first();
        $subjects = Subject::all();
        $classes = ClassTable::all();
        $students = Student::all();
        $studentDetails = array();
        $eachDetails = array();
        foreach ($subjects as $subject) {
            foreach ($students as $student) {
                $eachDetails['teacher_id'] = 0;     // we can decide to retain teacher thus choosing class and populating them with teacher_id both in student details and classTables. 
                $eachDetails['subject_id'] = $subject->id;
                $eachDetails['class_id'] = $student->class_id;
                $eachDetails['student_id'] = $student->id;
                $eachDetails['season_id'] = $id;
                $studentDetails[] = $eachDetails;
            }
        }
        $resetSeasons = DB::table('seasons')->update(['status' => 0]);
        $activateSeason = DB::table('seasons')->where('id', $id)->update(['status' => 1]);
        $operationPopulate = DB::table('student_details')->insert($studentDetails);

        if ($season->term == 1) { $season->term == "1<sup>st</sup>"; }
        if ($season->term == 2) { $season->term == "2<sup>nd</sup>"; }
        if ($season->term == 3) { $season->term == "3<sup>rd</sup>"; }


        $seasonMessage = "The ".$season->term." term of ". $season->session. " Session has been opened";


        if($operationPopulate) {
            return redirect()->back()->with(['message'=> $seasonMessage, 'style' => 'alert-success']);
        }
        else {
            return redirect()->back()->with(['message'=> "Something Happened", 'style' => 'alert-danger']);
        }
    }

    public function activate($id) {
        $active = DB::table('seasons')->where('status', 1)->count();
        if($active == true) {
    	   $reset = DB::table('seasons')->where('status', 1)->update(['status' => 0]);
            if($reset) {
                $season = Season::find($id);
                $season->status = 1;
                $isSaved = $season->save();
                if ($isSaved) {
                    return redirect()->back()->with(['message' => 'Season Activated', 'style' => 'alert-success']);
                }
                else {
                    return redirect()->back()->with(['message'=> 'Ooops, Something happened', 'style' => 'alert-danger']);
                }
                
            }
            
        }

        else {
            $season = Season::find($id);
            $season->status = 1;
            $isSaved = $season->save();
            if ($isSaved) {
                return redirect()->back()->with(['message' => 'Season Activated', 'style' => 'alert-success']);
            }
            else {
                return redirect()->back()->with(['message'=> 'Ooops, Something happened', 'style' => 'alert-danger']);
            }
                
        }
    }
    public function makeCurrent($id) {
        $current = DB::table('seasons')->where('current', 1)->count();
        if($current == true) {
            $reset = DB::table('seasons')->where('current', 1)->update(['current' => 0]);
            if($reset) {
            	$season = Season::find($id);
            	$season->current = true;
            	$isSaved = $season->save();
            	if ($isSaved) {
            		return redirect()->back()->with(['message' => 'Season has been changed', 'style' => 'alert-success']);
            	}
            	else {
            		return redirect()->back()->with(['message'=> 'Ooops, Something happened', 'style' => 'alert-danger']);
            	}
            }

        }
        else {
            $season = Season::find($id);
                $season->current = true;
                $isSaved = $season->save();
                if ($isSaved) {
                    return redirect()->back()->with(['message' => 'Season has been changed', 'style' => 'alert-success']);
                }
                else {
                    return redirect()->back()->with(['message'=> 'Ooops, Something happened', 'style' => 'alert-danger']);
                }
        }
    }


    public function check() {
        $studentDetails = StudentDetail::all();
        return $studentDetails;
    }

    


}
