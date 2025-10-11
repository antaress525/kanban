<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KanbanRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'min:4'],
            'description' => ['nullable', 'string'],
            'color' => ['required'],
            'cover_image' => ['nullable', 'image', 'max:2000'],
        ];
    }

    public function messages(): array {
        return [
            'title.required' => 'le titre est obligatoire',
            'title.min' => 'le titre doit faire au moins 4 caractères',
            'title.max' => 'le titre ne doit pas dépasser 255 caractères',
            'color.required' => 'la couleur est obligatoire',
            'cover_image.image' => 'le fichier doit être une image',
            'cover_image.max' => "la taille de l'image ne doit pas dépasser 2MB",
        ];
    }
}
