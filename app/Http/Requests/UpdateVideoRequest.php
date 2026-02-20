<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVideoRequest extends FormRequest
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
        // dd($this->route('video'));
        return [
            'title' => [
                'required',
                Rule::unique('videos', 'title')->ignore($this->route('video')),
            ],
            'subTitle' => ['required'],
            'shortDescription' => ['required'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,wmv', 'max:20480'],
            'status' => ['required']
        ];
    }
}