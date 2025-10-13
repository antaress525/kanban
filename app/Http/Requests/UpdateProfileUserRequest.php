<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileUserRequest extends FormRequest
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
            'first_name' => ['required', 'min:3', 'max:60'],
            'last_name' => ['required', 'min:3', 'max:60'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array {
        return [
            '',
            'email.required' => 'le email est obligatoire',
            'first_name.required' => 'le prenom est obligatoire',
            'last_name.required' => 'le nom est obligatoire',
            'first_name.min' => 'le prenom doit faire au moins 3 caractères',
            'last_name.min' => 'le nom doit faire au moins 3 caractères',
            'email.max' => 'le titre ne doit pas dépasser 255 caractères',    
        ];
    }
}
