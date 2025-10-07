<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransactionAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_nis' => ['required', 'string', 'min:16', 'max:16'],
            'received_email' => ['required', 'email'],
            'received_phone' => ['required', 'string', 'min:11', 'max:12'],
            'created_at' => ['required', 'date', 'date_format:Y-m-d'],
            'note' => ['nullable', 'string'],
            'payment_method' => ['required', 'exists:payment_types,code_name'],
            'has_paid' => ['required', 'boolean'],
            'orders' => ['required', 'array', 'min:1'],
            'orders.*.product_variant_id' => ['required', 'exists:product_variants,id'],
            'orders.*.price' => ['required', 'integer'],
            'orders.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
