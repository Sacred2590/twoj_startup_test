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
            'name.required' => 'error.name.required',
            'name.string' => 'error.name.string',
            'name.max' => 'error.name.max',
            'surname.required' => 'error.surname.required',
            'surname.string' => 'error.surname.string',
            'surname.max' => 'error.surname.max',
            'artifacts.array' => 'error.artifacts.array',
            'artifacts.*.artifact_name.enum' => 'error.artifacts.artifact_name.name',
            'artifacts.*.artifact_name.string' => 'error.artifacts.artifact_name.string',
            'artifacts.*.artifact_name.max' => 'error.artifacts.artifact_name.max',
            'artifacts.*.artifact_value.string' => 'error.artifacts.artifact_value.string',
            'artifacts.*.artifact_value.max' => 'error.artifacts.artifact_value.max',
        ];
    }
}
