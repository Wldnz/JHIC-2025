<?php

namespace App\Http\Requests\Admin;

use App\Utilities\RoleLevelChecker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreAccountRequest extends FormRequest
{
    public static $availableRoles = [
        'admin',
        'article_creator',
        'student',
        'candidate',
    ];

    /**
     *
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!Auth::check()) return false;

        $accountRole = $this->input('role');

        if ($accountRole == 'super_admin') {
            return false;
        } else if ($accountRole == 'admin') {
            return RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'super_admin');
        } else if ($accountRole == 'article_creator') {
            return RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'admin');
        } else if ($accountRole == 'candidate' || $accountRole == 'student') {
            return RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'admin');
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname'  => ['required', 'string', 'min:1', 'max:255'],
            'email'     => ['required', 'email', 'min:1', 'max:255'],
            'phone'     => ['required', 'string', 'min:11', 'max:12'],
            'role'      => ['required', Rule::in(self::$availableRoles)],
        ];
    }
}
