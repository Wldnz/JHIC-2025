<?php

namespace App\Http\Requests\Admin;

use App\Utilities\RoleLevelChecker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'super_admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_methods.*' => ['required', 'accepted'],
        ];
    }
}
