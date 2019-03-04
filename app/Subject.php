<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Result;
class Subject extends Model
{
    //
    public function timesUploaded($classId, $subjectId, $seasonId) {
    	$timesUploaded = Result::where('class_id', $classId)->where('subject_id', $subjectId)->where('season_id', $seasonId)->first()->times_uploaded;
    	return $timesUploaded;
    }
}
