<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable;

    protected array $details;

    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function handle(): void
    {
        Mail::to($this->details['user'])
            ->queue(new OrderShipped($this->details['order']));
    }
}
