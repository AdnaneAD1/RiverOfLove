<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationMarkdownMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $id;
    public $name;
    /**
     * Create a new message instance.
     */
    public function __construct($email, $id, $name)
    {
        $this->email = $email;
        $this->id = $id;
        $this->name = $name;
    }

    public function build()
    {
        return $this->from("contact@riveroflove-residence.com")
                    ->subject("Confirmation de réservation")
                    ->markdown('emails.markdownreservation')
                    ->with([
                        'id' => $this->id,
                        'name' => $this->name,
                    ]);
    }
}
