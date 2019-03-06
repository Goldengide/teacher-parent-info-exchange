<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Result;
class Subject extends Model
{
    //

    public function result($classId, $subjectId, $seasonId) {
    	$checkResult = Result::where('class_id', $classId)->where('subject_id', $subjectId)->where('season_id', $seasonId)->count();
    	if(!$checkResult){
            $result = new Result;
            $result->times_uploaded = 0;
    		return $result;
    	}
    	else {
            $result = Result::where('class_id', $classId)->where('subject_id', $subjectId)->where('season_id', $seasonId)->first();
    		$result = Result::where('class_id', $classId)->where('subject_id', $subjectId)->where('season_id', $seasonId)->first();
    		return $result;
    	}
    }
}
