<?php

namespace App\Http\Requests\Admin;

use App\Utilities\RoleLevelChecker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'candidate_nisn' => ['required', 'string', 'exists:candidates,nisn'],
            'total_cost' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'exists:payment_methods,code_name'],
            'has_paid' => ['required', 'boolean'],
        ];
    }
}
