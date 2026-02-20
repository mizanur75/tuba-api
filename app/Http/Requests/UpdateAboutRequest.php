<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title1' => 'required|string|max:255',
            'description1' => 'required|string',
            'image1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'title2' => 'required|string|max:255',
            'description2' => 'required|string',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'required|boolean',
        ];
    }
}