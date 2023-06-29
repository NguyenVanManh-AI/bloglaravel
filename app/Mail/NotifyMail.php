<?php
    
namespace App\Mail;
    
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
    
class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name_user ; 
    public function __construct($name_user)
    {
        $this->name_user = $name_user;
    }
    public function build()
    {
        return $this->view('emails.registerSuccess')->with('name_user', $this->name_user);
    }
}