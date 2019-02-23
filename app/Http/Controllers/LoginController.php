<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/teacher/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    public function loginPost(Request $request) {
        if(Auth::attempt(['email'=>$request->input('email'), 'password'=>$request->input('password') ]))
        {
            if(Auth::user() && Auth::user()->role == "admin")
            {
                return redirect('/super-admin/dashboard');
            }
            
            if(Auth::user() && Auth::user()->role == "parent")
            {
                return redirect('/parent/dashboard');
            }

            if(Auth::user() && Auth::user()->role == "teacher")
            {
                return redirect('/teacher/dashboard');
            }
            
            

            /*if(Auth::user() && Auth::user()->role == 'regular')
            {
                return redirect('/400');
            }*/
        }
        else {
            return redirect()->back()->with(['message'=>'Your credentials are not matching with our records. Please try again', 'style' => 'alert-danger']);
        }
    }

    // public function login
}