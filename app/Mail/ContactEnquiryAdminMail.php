<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEnquiryAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $enquiry)
    {
    }

    public function build(): self
    {
        return $this->subject('New website enquiry — '.$this->enquiry->names)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.contact-enquiry-admin');
    }
}
