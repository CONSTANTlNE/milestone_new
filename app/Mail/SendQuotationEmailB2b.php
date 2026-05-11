<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendQuotationEmailB2b extends Mailable
{
    use SerializesModels;

    public $mobile;

    public $quotations;

    public $signed_url;

    public function __construct($mobile, $quotations,$signed_url)
    {
        $this->mobile = $mobile;
        $this->quotations = $quotations;
        $this->signed_url = $signed_url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Offer from MilestoneBrokers',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.b2b_quotation_offer_2',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
