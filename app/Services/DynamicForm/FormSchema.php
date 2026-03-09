<?php

namespace App\Services\DynamicForm;

use App\Services\Contracts\FormSchemaInterface;
use Illuminate\Support\Collection;

class FormSchema implements FormSchemaInterface
{
    public function __construct(protected array $config)
    {
    }

    public static function fromArray(array $config): static
    {
        return new static($config);
    }

    public function getId(): string
    {
        return $this->config['id'];
    }

    public function getTitle(): string
    {
        return $this->config['title'] ?? '';
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getHandler(): ?string
    {
        return $this->config['handler'] ?? null;
    }

    public function getSteps(): Collection
    {
        return collect($this->config['steps'] ?? []);
    }

    public function getStep(int $index): ?array
    {
        return $this->getSteps()->get($index);
    }

    public function getStepsCount(): int
    {
        return $this->getSteps()->count();
    }

    public function getValidationRules(int $stepIndex, array $formData = []): array
    {
        $step = $this->getStep($stepIndex);
        if (!$step) {
            return [];
        }

        $rules = [];
        foreach ($step['fields'] as $field) {
            if (!$this->isFieldVisible($field, $formData)) {
                continue;
            }

            if (!empty($field['validation'])) {
                $rules[$field['id']] = $field['validation'];
            }
        }

        return $rules;
    }

    public function getValidationMessages(int $stepIndex): array
    {
        $step = $this->getStep($stepIndex);
        if (!$step) {
            return [];
        }

        $messages = [];
        foreach ($step['fields'] as $field) {
            foreach ($field['messages'] ?? [] as $rule => $message) {
                $messages["{$field['id']}.{$rule}"] = $message;
            }
        }

        return $messages;
    }

    public function isFieldVisible(array $field, array $formData): bool
    {
        if (empty($field['condition'])) {
            return true;
        }

        $condition = $field['condition'];
        $value = $formData[$condition['field']] ?? null;

        return match ($condition['operator'] ?? 'equals') {
            'equals' => $value == $condition['value'], // Поля равны
            'not_equals' => $value != $condition['value'], // Поля не равны
            'in' => in_array($value, (array)$condition['value']), // Входит в список
            'not_in' => !in_array($value, (array)$condition['value']), // Не входит в список
            'not_empty' => !empty($value), // Заполнено поле
            'empty' => empty($value), // Не заполнено
            default => true,
        };
    }
}
