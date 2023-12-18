<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $user;

    public function __construct($comment, $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject("New comment on post you commented created")->view('mail.createcomment');
    }
}
