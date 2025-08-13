<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiagnosisRequest extends FormRequest
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
            'symptoms' => 'required|array|min:1',
            'symptoms.*' => 'integer|exists:symptoms,id',
            'session_id' => 'nullable|string|max:100',
            'motorcycle_model' => 'nullable|string|max:255',
            'motorcycle_year' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'mileage' => 'nullable|integer|min:0|max:999999',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'symptoms.required' => 'Please select at least one symptom to proceed with diagnosis.',
            'symptoms.min' => 'Please select at least one symptom.',
            'symptoms.*.integer' => 'Invalid symptom selection.',
            'symptoms.*.exists' => 'One or more selected symptoms are invalid.',
            'motorcycle_year.integer' => 'Motorcycle year must be a valid year.',
            'motorcycle_year.min' => 'Motorcycle year must be 1990 or later.',
            'motorcycle_year.max' => 'Motorcycle year cannot be in the future.',
            'mileage.integer' => 'Mileage must be a valid number.',
            'mileage.min' => 'Mileage cannot be negative.',
            'mileage.max' => 'Mileage value is too high.',
        ];
    }
}