<?php

namespace App\Http\Requests\Candidate;

use App\Utilities\RoleLevelChecker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SaveStage3Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'candidate');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phase_id' => ['required'],
            'registration_source' => ['required'],
            'enrolling_reason' => ['required', 'string', 'max:65535'],
        ];
    }
}
