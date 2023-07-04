<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $url ; 
    public function __construct($url)
    {
        $this->url = $url;
    }
    public function build()
    {
        return $this->view('Blog.Auth.emails.sendCode')->with('url', $this->url);
    }
}
