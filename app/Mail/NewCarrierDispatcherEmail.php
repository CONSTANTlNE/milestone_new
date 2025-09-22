<?php

namespace App\Mail;

use App\Models\CarrierDispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCarrierDispatcherEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $carrierDispatcher;

    /**
     * Create a new message instance.
     */
    public function __construct(CarrierDispatcher $carrierDispatcher)
    {
        $this->carrierDispatcher = $carrierDispatcher;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Carrier/Dispatcher Application - ' . $this->carrierDispatcher->legal_business_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.carrier_dispatcher_application',
            with: [
                'carrierDispatcher' => $this->carrierDispatcher,
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
