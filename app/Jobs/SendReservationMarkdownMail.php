<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMarkdownMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReservationMarkdownMail implements ShouldQueue
{
    use Queueable;

    protected $mailabler;
    protected $email;
    protected $id;
    public function __construct(ReservationMarkdownMail $email, $mailabler)
    {
        $this->mailabler = $mailabler;
        $this->email = $email;
    }

    public function handle()
    {
        Mail::to($this->email)->send($this->mailabler);
    }
}
