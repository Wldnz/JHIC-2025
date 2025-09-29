<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'category' => ['required', 'string', 'in:uniform,attribute'],
            'description' => ['required', 'string', 'min:1', 'max:65535'],
            'images.*.thumbnail' => ['required', 'boolean'],
            'images.*.file' => ['sometimes', 'required', 'image', 'mimes:jpg,jpeg,png', 'max:2500'],
            'variants.*.id' => ['required'],
            'variants.*.name' => ['required', 'string', 'min:1', 'max:60'],
            'variants.*.type' => ['required', 'string', 'min:1', 'max:60'],
            'variants.*.price' => ['required', 'integer', 'min:1'],
            'variants.*.stock' => ['required', 'integer', 'min:1'],
        ];
    }
}
