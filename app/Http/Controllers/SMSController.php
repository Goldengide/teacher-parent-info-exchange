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
    public function send() {
    	$from= $this->from;
    	$to= $this->to;
    	$subject= $this->subject;
    	$cc= $this->cc;
    	$bcc= $this->bcc;
    	$text= $this->text;
        $message = new Message;
        $message->from = $from; // ( provided by the page );
        $message->to= $to; // ( provided by the page )
        $message->subject= $this->subject;
        $message->cc= ;//admin;
        // $message->bcc= $this->bcc;
        $message->text= $this->text;
        $message->save();

    	$message = new Message;
    	if($mesage) {
    		return "Message Sent";
    	}
    }

    
}
