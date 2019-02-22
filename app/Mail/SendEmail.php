<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\User;
use Redirect;


class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $description;
    
    public function __construct($subject, $description)
    {
        $this->$subject = $subject;
        $this->$description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $e_subject = $request->subject;
        $e_description = $request->description;
        return $this->view('mail.index')->subject($e_subject, $e_description);
    }
}
