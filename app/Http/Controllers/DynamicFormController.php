<?php

namespace App\Http\Controllers;

use App\Services\DynamicForm\FormSchema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DynamicFormController extends Controller
{
    public function validateStep(Request $request, string $formId, int $step): RedirectResponse
    {
        $schema = $this->loadSchema($formId);
        abort_if(!$schema, 404);

        $allData = $request->input('formData', []);
        $rules = $schema->getValidationRules($step, $allData);
        $messages = $schema->getValidationMessages($step);

        $stepFields = collect($schema->getStep($step)['fields'] ?? [])->pluck('id')->all();
        $stepData = array_intersect_key($allData, array_flip($stepFields));

        $validator = Validator::make($stepData, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        return back();
    }

    public function submit(Request $request, string $formId): RedirectResponse
    {
        $schema = $this->loadSchema($formId);
        abort_if(!$schema, 404);

        $allData = $request->input('formData', []);
        $allRules = [];
        $allMessages = [];

        foreach (range(0, $schema->getStepsCount() - 1) as $step) {
            $allRules = array_merge($allRules, $schema->getValidationRules($step, $allData));
            $allMessages = array_merge($allMessages, $schema->getValidationMessages($step));
        }

        $validator = Validator::make($allData, $allRules, $allMessages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $handlerClass = $schema->getHandler();
        if ($handlerClass) {
            app($handlerClass)->handle($validator->validated());
        }

        return back()->with('success', true);
    }

    protected function loadSchema(string $formId): ?FormSchema
    {
        $schemas = config('dynamic_form.schemas', []);

        if (!isset($schemas[$formId])) {
            return null;
        }

        return FormSchema::fromArray($schemas[$formId]);
    }
}
