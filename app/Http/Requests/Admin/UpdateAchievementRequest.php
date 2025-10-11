<?php

namespace App\Http\Requests\Admin;

use App\Utilities\RoleLevelChecker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAchievementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && \App\Utilities\RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_nis' => ['nullable', 'string', 'exists:students,nis'],
            'images.*.thumbnail' => ['required', 'boolean'],
            'images.*.file' => ['sometimes', 'required', 'image', 'mimes:jpg,jpeg,png', 'max:2500'],
            'competition_name' => ['required', 'string', 'min:1', 'max:255'],
            'won_at' => ['required', 'date', 'date_format:Y-m-d'],
            'competition_position' => ['required', 'string', 'in:grade_1,grade_2,grade_3'],
            'competition_level' => ['required', 'string', 'in:school,subdistrict,district,provincial,national,international'],
        ];
    }
}
