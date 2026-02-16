<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->has('bank') && $this->has('transaction_data');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bank' => 'required|string',
            'transaction_data' => 'required|string',
        ];
    }
}
