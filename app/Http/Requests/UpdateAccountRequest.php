<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
        /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role == "superAdmin";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'fullname' => ['required', 'string', 'min:1', 'max:255'],
            'no_telp' => ['required_if:role,siswa' , 'unique:users,no_telp', 'string', 'min:11', 'max:12'],
            'gender' => ['required_if:role,siswa', 'string', 'in:male,female'],
            'address' => ['required_if:role,siswa', 'string', 'min:1', 'max:65535'],
            'birthdate' => ['required_if:role,siswa', 'date', Rule::date()->beforeToday()],
            'class' => ['required_if:role,siswa', 'string', 'in:X,XI,XII'],
            'major_id' => ['required_if:role,siswa', 'integer', 'exists:majors,id'],
            'role' => ['required', 'string', 'in:siswa,admin'],
        ];
    }
}
