<?php

namespace App;
use App\ClassTable;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    public function classTable($id) {
    	$class = ClassTable::where('id', $id)->first();
        if($class->teacher_id == 0) {
            $class->teacher->fullname = "No Teacher";
            $class->teacher->firstname = "No Teacher";
            $class->teacher->lastname = "No Teacher";
            $class->teacher->othernames = "No Teacher";
            $class->teacher->id = "No Teacher";
        }
        return $class;
    }

    public function parent($parent_name) {

    	$parent = User::where('fullname', $parent_name)->first();
    	return $parent;	
    }

}
