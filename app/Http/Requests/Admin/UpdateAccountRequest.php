<?php

namespace App\Http\Requests\Admin;

use App\Utilities\RoleLevelChecker;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    public static $availableRoles = [
        'admin',
        'article_creator',
        'student',
        'candidate',
    ];
    public static $availableCitizenships = [
        'indonesia',
        'other',
    ];
    public static $availableReligions = [
        'islam ',
        'catholic ',
        'buddha ',
        'hindu ',
        'protestant ',
        'confucian ',
        'other',
    ];
    public static $availableStatusFamilies = [
        'biological_child',
        'adopted_child',
        'step_child',
        'foster_child',
    ];
    public static $availableGuardianTypes = [
        'mother',
        'father',
        'other',
    ];

    /**
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
        $baseRules = [
            'fullname'  => ['required', 'string', 'min:1', 'max:255'],
            'email'     => ['required', 'email', 'min:1', 'max:255'],
            'phone'     => ['required', 'string', 'min:11', 'max:12'],
            'role'      => ['required', Rule::in(self::$availableRoles)],
        ];
        $candidateRules = [
            'candidate_nisn'        => ['required', 'string', 'exists:candidates,nisn'],
            'candidate_short_name'  => ['nullable', 'string', 'max:100'],
            'candidate_birth_date'  => ['required', 'date', 'date_format:Y-m-d'],
            'candidate_birth_place' => ['required', 'string', 'max:255'],
            'gender'                => ['required', 'in:male,female'],
            'citizenship'           => ['nullable', Rule::in($this->availableCitizenships)],
            'religion'              => ['nullable', Rule::in($this->availableReligions)],
            'address'               => ['nullable', 'string', 'min:1', 'max:65535'],
            'status_family'         => ['nullable', Rule::in($this->availableStatusFamilies)],
            'order_family'          => ['nullable', 'integer', 'min:1'],
            'sum_siblings'          => ['nullable', 'integer', 'min:0'],
            'sum_half_siblings'     => ['nullable', 'integer', 'min:0'],
            'sum_adopted_siblings'  => ['nullable', 'integer', 'min:0'],
            'phone'                 => ['required', 'string', 'min:11', 'max:12'],
            'origin_school'         => ['required', 'string', 'min:1', 'max:255'],
            'origin_school_address' => ['required', 'string', 'min:1', 'max:255'],
        ];
        $candidateRegistrationSourceRules = [
            'registration_source'   => ['nullable', 'exists:registration_sources,id'],
            'enrolling_reason'      => ['required', 'string', 'min:1', 'max:65535'],
        ];
        $candidateRegistrationPhaseRules = [
            'phase.id'              => ['nullable', 'exists:registration_phases,id'],
        ];
        $candidateGuardianRules = [
            'candidate_guardian_name'                   => ['required', 'string', 'min:1', 'max:255'],
            'candidate_guardian_birthdate'              => ['required', 'date', 'date_format:Y-m-d'],
            'candidate_guardian_birthplace'             => ['required', 'string', 'max:255'],
            'candidate_guardian_education'              => ['required', 'string', 'max:150'],
            'candidate_guardian_job'                    => ['required', 'string', 'max:150'],
            'candidate_guardian_monthly_income'         => ['required', 'string', 'min:0'],
            'candidate_guardian_citizenship'            => ['required', Rule::in($this->availableCitizenships)],
            'candidate_guardian_religion'               => ['required', Rule::in($this->availableReligions)],
            'candidate_guardian_city'                   => ['required', 'min:1', 'max:255'],
            'candidate_guardian_district'               => ['required', 'min:1', 'max:255'],
            'candidate_guardian_sub_district'           => ['required', 'min:1', 'max:255'],
            'candidate_guardian_rt_rw'                  => ['required', 'min:1', 'max:10'],
            'candidate_guardian_postal_code'            => ['required', 'min:11', 'max:11'],
            'candidate_guardian_address'                => ['required', 'min:1', 'max:65535'],
            'candidate_guardian_office_phone_number'    => ['nullable', 'min:11', 'max:12'],
            'candidate_guardian_home_phone_number'      => ['nullable', 'min:11', 'max:12'],
            'candidate_guardian_phone_number'           => ['required', 'min:11', 'max:12'],
        ];

        if ($this->input('role') == 'candidate') {
            return array_merge(
                $baseRules,
                $candidateRules,
                $candidateRegistrationSourceRules,
                $candidateRegistrationPhaseRules,
                $candidateGuardianRules
            );
        } else {
            return $baseRules;
        }
    }
}
