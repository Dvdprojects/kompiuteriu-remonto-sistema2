<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CustomerEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $name, $mobile, $subject, $text, $account;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $mobile, $subject, $text, $account)
    {
        $this->name = $name;
        $this->mobile = $mobile;
        $this->subject = $subject;
        $this->text = $text;
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Auth::user()->email)
            ->view('customerEmail');
    }
}
