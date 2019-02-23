<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassTable extends Model
{
    //
    public function teacher($teacherId) {
    	$teacher = User::where('id', $teacherId);
    	return $teacher;
    	// return $this->belongsTo(User::class, 'teacher_id');

    }
}
