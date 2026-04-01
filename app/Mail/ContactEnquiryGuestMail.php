<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEnquiryGuestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $enquiry)
    {
    }

    public function build(): self
    {
        return $this->subject('We received your message — '.config('app.name'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.contact-enquiry-guest');
    }
}
