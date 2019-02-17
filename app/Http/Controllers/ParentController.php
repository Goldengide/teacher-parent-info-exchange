<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ParentController extends Controller
{
    //
    public function dashboard() {
    	$noOfStudents = 20; 
    	$noOfSubjects = 15;
    	return view('parent-dashboard', compact('noOfStudents, noOfSubjects'));
    }
}
