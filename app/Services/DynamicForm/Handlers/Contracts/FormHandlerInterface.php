<?php

namespace App\Services\DynamicForm\Handlers\Contracts;

interface FormHandlerInterface
{
    public function handle(array $data): void;
}
