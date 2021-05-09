<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class StateMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name, $number, $busena, $mailBox;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $number, $busena, $mailBox)
    {
        $this->name = $name;
        $this->number = $number;
        $this->busena = $busena;
        $this->mailBox = $mailBox;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Auth::user()->email)
            ->view('emails.stateEmail');
    }
}
