<?php

namespace App\Http\Requests\Admin;

use App\Utilities\RoleLevelChecker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentRequest extends FormRequest
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
            'nis' => ['required', 'string', 'min:17', 'max:17'],
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'birth_date' => ['required', 'date', 'date_format:Y-m-d'],
            'gender' => ['required', 'in:male,female'],
            'class' => ['required', 'in:X,XI,XII'],
            'major_id' => ['required', 'exists:majors,id'],
        ];
    }
}
