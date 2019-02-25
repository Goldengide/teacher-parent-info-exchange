<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Student;
use App\Subject;
use App\ClassTable;

class StudentDetail extends Model
{
    //
    public function student($studentId) {
    	return Student::where('id', $studentId)->value('student_name');
    }
    public function subject($subjectId) {
    	return Subject::where('id', $subjectId)->value('name');
    }
    public function classT($classId) {
    	return ClassTable::where('id', $classId)->value('name');
    }
    public function teacher($teacherId) {
    	
    	return User::where('id', $teacherId)->value('name');
    }

}
