<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'company_id' => 'sometimes|required|exists:companies,id',
            'visibility' => 'sometimes|required|in:general,company_only',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'sometimes|required|in:full-time,part-time,contract',
            'work_style'=> 'sometimes|required|in:Onsite,Remote,Hybrid',
            'salary_range' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ];
    }
}
