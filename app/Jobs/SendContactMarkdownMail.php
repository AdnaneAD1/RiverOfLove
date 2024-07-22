<?php

namespace App\Jobs;

use App\Mail\ContactMarkdownMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendContactMarkdownMail implements ShouldQueue
{
    use Queueable;

    protected $mailablec;
    /**
     * Create a new job instance.
     */
    public function __construct(ContactMarkdownMail $mailablec)
    {
        $this->mailablec = $mailablec;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to('contact@riveroflove-residence.com')->send($this->mailablec);
    }
}
