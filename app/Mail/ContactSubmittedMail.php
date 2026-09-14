<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $email;
    public string $phone;
    public string $customerMessage;

    public function __construct(string $name, string $email, string $phone, string $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->customerMessage = $message;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address', 'tn7410311@gmail.com'), config('mail.from.name', 'Tâm Barbershop')),
            replyTo: [new Address($this->email, $this->name)],
            subject: 'Tin nhắn liên hệ mới từ khách hàng',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-notification',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'customer_message' => $this->customerMessage,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
