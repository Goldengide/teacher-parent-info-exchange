<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{
    //
    public function dashboard() {
    	$noOfStudents = Student::count();
    	$noOfTeachers = User::where('role', 'teacher')->count();

    	return view('teacher-dashboard', compact('noOfStudents', 'noOfTeachers'));
    }
}
