<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NoMultipleSpacesRule;
use App\Rules\TitleValidationRule;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        $method = $this->method();
        /* $taskId = $this->route('task') ?? null;

        if (!empty($taskId) && ($method === 'PUT' || $method === 'PATCH')) {
            $rules['id'] = $taskId;
        } */
        $rules['title']         = ['required', 'max:255', new NoMultipleSpacesRule(), new TitleValidationRule()];
        $rules['description']   = ['nullable', 'string',new NoMultipleSpacesRule];
        $rules['due_date']      = ['required', 'date', 'after_or_equal:today'];
        $rules['status']        = ['nullable', 'in:' . implode(',', config('constant.status'))];
        
        return $rules;
    }
}
