<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoreRequestComment extends FormRequest
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
            'body' => 'required|string|min:25|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'body.required' => __('A comment is required.'),
            'body.string' => __('The comment must be text.'),
            'body.min' => __('The comment must be at least 25 characters long.'),
            'body.max' => __('The comment cannot exceed 255 characters.'),
        ];
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, string>
     */
    protected function failedValidation(Validator $validator): array
    {
        throw ValidationException::withMessages(
            $validator->errors()->getMessages()
        )->redirectTo(route('posts.show', $this->post->slug).'#comments');
    }
}
