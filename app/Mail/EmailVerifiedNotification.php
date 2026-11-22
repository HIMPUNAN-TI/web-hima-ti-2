<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerifiedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Akun & Email Anda Telah Berhasil Diverifikasi - HIMAPRODI TI',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verified',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
