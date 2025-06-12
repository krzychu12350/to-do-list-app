<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to-do,in progress,done',
            'due_date' => 'required|date|after_or_equal:today',
            'sync_with_google_calendar' => 'nullable|boolean',
        ];
    }

    /**
     * Override validated() to ensure sync_with_google_calendar is always a boolean.
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Force boolean casting here
        $data['sync_with_google_calendar'] = $this->boolean('sync_with_google_calendar', false);

        return $data;
    }
}
