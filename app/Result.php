<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Subject;
use App\ClassTable;
use App\Season;

class Result extends Model
{
    //
    public function subject($subjectId) {
    	$subject = Subject::where('id', $subjectId)->first();
    	return $subject;
    }
    public function class($classId) {
    	$class = ClassTable::where('id', $classId)->first();
    	return $class;
    }
    public function Season($seasonId) {
    	$season = Season::where('id', $seasonId)->first();
    	return $season;
    }

    public function student($studentId) {
    	$student = Student::where('id', $studentId)->first();
    	return $student;
    }
}
