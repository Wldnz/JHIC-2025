<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSettingsRequest extends FormRequest
{
    private $authorizedRoles = ['admin', 'superAdmin'];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, $this->authorizedRoles);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_methods.*' => ['nullable', 'accepted'],
        ];
    }
}
