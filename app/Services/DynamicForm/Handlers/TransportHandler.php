<?php

namespace App\Services\DynamicForm\Handlers;

use App\Mail\ContactFormMail;
use App\Services\DynamicForm\Handlers\Contracts\FormHandlerInterface;
use Illuminate\Support\Facades\Mail;

class TransportHandler implements FormHandlerInterface
{
    public function handle(array $data): void
    {
        Mail::to('admin@site.com')->send(new ContactFormMail($data));
    }
}
