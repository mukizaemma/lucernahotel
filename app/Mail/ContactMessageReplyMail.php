<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $enquiry)
    {
    }

    public function build(): self
    {
        return $this->subject('Reply from '.config('app.name'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.contact-message-reply');
    }
}
