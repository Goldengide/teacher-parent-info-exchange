<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Message;

class SMSController extends Controller
{
    //

    public $from, $to, $text, $subject, $cc $bcc; $template; 

    // public function send($from, $to, $text, $subject, $cc $bcc; $template) {
    public function sendMail() {
    	$from= $this->from;
    	$to= $this->to;
    	$subject= $this->subject;
    	$cc= $this->cc;
    	$bcc= $this->bcc;
    	$text= $this->text;
        
    }
    public function sendSMS($from, $to, $text) {
        
        
    }


    public function sendAdminMessagePage(){
        return view('pages.super-admin-send-message');
    }
    
    public function sendAdminMessage(Request $request){
        $SMSfrom = $request->from;
        $phones = User::where('role', 'admin')->pluck('phone');
        $phones = implode(",", $phones);
        $SMSto = $phone .",". $request->cc;
        $SMStext = $request->text;
        $this->sendSMS($SMSfrom, $SMSto, $SMStext);

        $message = new Message;
        $message->from = $from;
        $message->to= 'admin';
        // $message->subject= $this->subject;
        $message->cc= $request->cc;
        $message->text= $request->text;
        $message->save();

        if($mesage) {
            return "Message Sent";
        }       
    }

    public function sendTeacherMessage(Request $request){
        $SMSfrom = $request->from;
        $SMSto = $request->to .",". $request->cc;
        $SMStext = $request->text;
        // $this->subject = null;
        $this->sendSMS($SMSfrom, $SMSto, $SMStext);

        $message = new Message;
        $message->from = $from; 
        $message->to= $request->user_id; 
        // $message->subject= $this->;
        $message->cc= $request->cc;
        $textTemplate = "Good morning,". $request->name;
        $message->text= $textTemplate. "\n".$request->text;
        $message->save();

        if($mesage) {
            return "Message Sent";
        }        
    }


    public function sendParentMessage(Request $request){
        $SMSfrom = $request->from;
        $SMSto = $request->to .",". $request->cc;
        $SMStext = $request->text;
        // $this->subject = null;
        $this->sendSMS($SMSfrom, $SMSto, $SMStext);

        $message = new Message;
        $message->from = $from; 
        $message->to= $to; 
        // $message->subject= $this->subject;
        $message->cc= $request->cc;
        $textTemplate = "Good morning,". $request->name;
        $message->text= $textTemplate ."\n". $request->text;
        $message->save();

        if($mesage) {
            return "Message Sent";
        }       
    }

    
    
}
