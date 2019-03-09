<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSummary extends Model
{
    //
    public function getBestStudents($classId, $seasonId) {
    	$maxScore = StudentSummary::where('class_id', $classId)->where('season_id', $seasonId)->max('percentage');
    	$bestStudent = StudentSummary::where('percentage', $maxScore)->where('class_id', $classId)->where('season_id', $seasonId)->get();
    	return $bestStudent;
    }

    public function student($studentId)  {
    	$student = Student::where('id', $studentId)>first();
    	return $student;
    }
}
