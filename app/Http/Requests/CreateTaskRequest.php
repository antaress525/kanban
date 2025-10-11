<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'min:4', 'max:100'],
            'description' => ['nullable', 'string', 'min:4', 'max:255'],
            'status' => ['required', Rule::enum(TaskStatus::class)]
        ];
    }

    public function messages(): array {
        return [
            'title.required' => 'le titre est obligatoire',
            'title.min' => 'le titre doit faire au moins 4 caractères',
            'title.max' => 'le titre ne doit pas dépasser 100 caractères',
            'description.min' => 'la description doit faire au moins 4 caractères',
            'description.max' => 'la description ne doit pas dépasser 255 caractères',     
        ];
    }
}
