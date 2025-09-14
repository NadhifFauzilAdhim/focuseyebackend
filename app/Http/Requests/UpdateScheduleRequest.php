<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization is handled by SchedulePolicy
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
            'description' => 'nullable|string|max:1000',
            'details' => 'present|array',
            'details.*.name' => 'required|string|max:255',
            'details.*.description' => 'nullable|string|max:1000',
            'details.*.start_date' => 'required|date_format:Y-m-d H:i:s',
            'details.*.end_date' => 'required|date_format:Y-m-d H:i:s|after:details.*.start_date',
        ];
    }
}
