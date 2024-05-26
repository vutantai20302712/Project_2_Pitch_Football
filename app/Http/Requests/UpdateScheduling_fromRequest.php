<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduling_fromRequest extends FormRequest
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
            //
            'customer_id' => 'required|exists:customers,id',
            'admin_id' => 'required|exists:admins,id',
            'payment_method' => 'required|exists:payments,id',
            'scheduling_form_status' => 'required|string',
            'scheduling_form_date' => 'required|date',
        ];
    }
}
