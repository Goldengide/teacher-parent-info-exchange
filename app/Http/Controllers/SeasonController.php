<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Season;

class SeasonController extends Controller
{
    //
    public function index() {
    	$seasons = Season::all();
    	$currentSession  = "unset";
    	$currentTerm  = "unset";
	    $currentSeason = Season::where('current', 1)->first();
    	if(count($currentSeason) > 0) {
	    	$currentSession = $currentSeason->session;
	    	$currentTerm = $currentSeason->term_no;
	    	if($currentTerm == 1) {$currentTerm = '1'."<sup>st</sup>";}
	    	if($currentTerm == 2) {$currentTerm = '2'."<sup>nd</sup>";}
	    	if($currentTerm == 3) {$currentTerm = '3'."<sup>rd</sup>";}
    	}
    	return view('pages.super-admin-seasons-index', compact('seasons', 'currentTerm', 'currentSession'));
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
    		return (['message'=> 'Seasons Generation Successful', 'style' => 'alert-success']);
    	}
    }

    public function generateSeasonsInterface() {
    	return view('seasons-generate-page');
    }

    public function generateSeasonsAction(Request $request) {

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

}
