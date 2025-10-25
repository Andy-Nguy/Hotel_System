<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingData;
    public $customerData;
    public $statusType; // 'confirmed' or 'cancelled'

    public function __construct($bookingData, $customerData = [], $statusType = 'confirmed')
    {
        $this->bookingData = $bookingData;
        $this->customerData = $customerData;
        $this->statusType = $statusType;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác nhận đặt phòng - ' . ($this->bookingData['IDDatPhong'] ?? ''),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_confirmation',
            with: [
                'bookingData' => $this->bookingData,
                'customerData' => $this->customerData,
                'statusType' => $this->statusType,
            ],
        );
    }

}
