<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface FormSchemaInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getConfig(): array;

    public function getHandler(): ?string;

    public function getSteps(): Collection;

    public function getStep(int $index): ?array;

    public function getStepsCount(): int;

    public function getValidationRules(int $stepIndex, array $formData = []): array;

    public function getValidationMessages(int $stepIndex): array;

    public function isFieldVisible(array $field, array $formData): bool;
}
