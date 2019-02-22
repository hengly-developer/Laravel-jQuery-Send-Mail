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
        if ($request->ajax()) {

            $email = $request->get('email');
            $cc = $request->get('cc');
            $ccs = $request->get('cc');
            $bcc = $request->get('bcc');
            $subject = $request->get('subject');
            $description = $request->get('description');

            if($cc== null & $bcc == null){

                Mail::send('mail.index', $email, function($message) use ($email){
                    $message->to($email)
                            ->subject($subject,$description);
                });
                
            }else if($cc== null){

                Mail::to($email)
                    ->bcc($bcc)
                    ->send(new SendEmail($subject, $description));

            }else if($bcc == null){

                Mail::to($email)
                    ->cc($cc)
                    ->send(new SendEmail($subject, $description));
            }else{

                Mail::to($email)
                    ->cc($cc)
                    ->bcc($bcc)
                    ->send(new SendEmail($subject, $description));
            }
        }
	    return view('mail.index');
    }
    public function getTemplate(){

        return view('mail.templates')->render();
    }
}
