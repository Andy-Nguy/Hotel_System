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

    public function __construct($bookingData, $customerData = [])
    {
        $this->bookingData = $bookingData;
        $this->customerData = $customerData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác nhận đặt phòng - ' . ($this->bookingData['IDDatPhong'] ?? ''),
        );
    }

    public function content(): Content
    {
        $view = 'emails.booking_confirmation';
        if (isset($this->bookingData['TrangThai']) && intval($this->bookingData['TrangThai']) === 0) {
            $view = 'emails.booking_cancelled';
        }

        return new Content(
            view: $view,
            with: [
                'bookingData' => $this->bookingData,
                'customerData' => $this->customerData,
            ],
        );
    }

}
