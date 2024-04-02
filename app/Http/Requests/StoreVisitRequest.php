<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreVisitRequest extends FormRequest
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
            'visit_purpose' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'description' => ['required'],
            'spk' => ['nullable', 'mimes:doc,docx,pdf', 'max:2048'],
            'visitors' => ['array', 'min:1'],
            'visitors.*.ktp' => ['required', 'unique:visitors'],
            'visitors.*.name' => ['required'],
            'visitors.*.file_ktp' => ['required', 'mimes:png,jpg,jpeg,pdf', 'max:2048'],
            'visitors.*.company' => ['required'],
            'visitors.*.occupation' => ['required'],
            'visitors.*.phone' => ['required'],
            'visitors.*.email' => ['required'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];
    }

    public function messages(): array
    {
        return [
            'visitors.*.ktp.unique' => 'The KTP has already been taken.',
            'visitors.*.ktp.required' => 'The KTP field is required.',
            'visitors.*.name.required' => 'The name field is required.',
            'visitors.*.file_ktp.required' => 'The File KTP field is required.',
            'visitors.*.company.required' => 'The company field is required.',
            'visitors.*.occupation.required' => 'The occupation field is required.',
            'visitors.*.phone.required' => 'The phone field is required.',
            'visitors.*.email.required' => 'The email field is required.',
        ];
    }
}
