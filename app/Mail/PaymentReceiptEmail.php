<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $subscription;
    public $isRenewal;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Subscription $subscription, bool $isRenewal = false)
    {
        $this->user = $user;
        $this->subscription = $subscription;
        $this->isRenewal = $isRenewal;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isRenewal 
            ? 'Payment Receipt - Subscription Renewed Successfully'
            : 'Payment Receipt - Welcome to Premium!';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-receipt',
            with: [
                'user' => $this->user,
                'subscription' => $this->subscription,
                'isRenewal' => $this->isRenewal,
                'loginUrl' => 'https://smart-keyholder.click/login',
                'dashboardUrl' => 'https://smart-keyholder.click/dashboard',
                'appName' => config('app.name'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}