<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    public function classTable($id) {
    	$class = ClassTable::where('id', $id)->first();
    	$class->teacher = User::where('id', $class->teacher_id)->first();
    	return $class;
    }

    public function parent($parent_name) {

    	$parent = User::where('fullname', $parent_name)->first();
    	return $parent;	
    }

}
