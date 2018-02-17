<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user; // and this user is available automatically in emails/welcome.blade.php
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // build is automatically executed by laravel when you send an email using this Mailable
    public function build()
    {
        return $this->text('emails.welcome');
    }
}
