<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inquiry $inquiry)
    {
        //
    }

    public function build(): self
    {
        return $this
            ->subject('New contact message from '.$this->inquiry->name)
            ->markdown('emails.contact-message');
    }
}
