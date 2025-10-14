<?php

namespace App\Http\Requests\Admin;

use App\Utilities\RoleLevelChecker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'article_creator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'visible' => ['required', 'in:draft,published,archived'],
            'tags.*' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2500'],
            'isUpdated' => ['nullable', 'image', 'boolean'],
            'content' => ['required', 'string', 'min:1'],
        ];
    }
}
