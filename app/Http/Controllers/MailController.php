<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Snowfire\Beautymail\Beautymail;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\SendEmail;

class MailController extends Controller
{
    
    public function index()
    {
        return view('mail.index');
    }

    public function sendMail(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "message" => "min:10"
        ]);   

        if ($request->ajax()) {

            $email = $request->get('email');
            $cc = $request->get('cc');
            $bcc = $request->get('bcc');
            $subject = $request->get('subject');
            $description = $request->get('description');

            Mail::to($email)
                ->cc($cc)
                ->bcc($bcc)
                ->send(new SendEmail($subject, $description));
        }
	    return view('mail.index');
    }
    public function getTemplate(){

        return view('mail.templates')->render();
    }
}
