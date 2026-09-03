<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fullname;
    public $email;
    public $phone;

    public function __construct($fullname, $email, $phone)
    {
        $this->fullname = $fullname;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Có người dùng mới đăng ký - Tâm Barbershop',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}