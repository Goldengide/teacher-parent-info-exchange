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

    public function summary($seasonId, $classId, $studentId) {
        $summary = Result::where('season_id', $seasonId)
                            ->where('class_id', $classId)
                            ->where('student_id', $studentId);
        $sum = $summary->sum('total');
        $count = $summary->count();
        $percentage = $sum / $count;
        $best_score = $summary->max('total');
        $worse_score = $summary->min('total');
        $returnValue = array('sum' => $sum, 'percentage' => $percentage, 'count' => $count, 'best_score' => $best_score, 'worse_score' => $worse_score,);

        $insertValue = array('season_id' => $seasonId, 'class_id' => $classId, 'student_id' => $studentId, 'percentage' => $percentage, 'best_score' => $best_score, 'worse_score' => $worse_score,);

        return $insertValue;
    }
}
