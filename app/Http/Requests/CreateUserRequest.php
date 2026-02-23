<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateUserRequest extends FormRequest
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
           'name' => 'required|string|max:255',
           'surname' => 'required|string|max:255',
           'artifacts' => 'sometimes|array',
           'artifacts.*.artifact_name' => ['required', 'string', 'max:255', new Enum(\App\Enums\UserArtifactsEnum::class)],
           'artifacts.*.artifact_value' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return list<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',
            'surname.required' => 'Surname is required.',
            'surname.string' => 'Surname must be a string.',
            'surname.max' => 'Surname must not exceed 255 characters.',
            'artifacts.array' => 'Artifacts must be an array.',
            'artifacts.*.artifact_name.string' => 'Artifact name must be a string.',
            'artifacts.*.artifact_name.max' => 'Artifact name must not exceed 255 characters.',
            'artifacts.*.artifact_value.string' => 'Artifact value must be a string.',
            'artifacts.*.artifact_value.max' => 'Artifact value must not exceed 255 characters.',
        ];
    }
}
