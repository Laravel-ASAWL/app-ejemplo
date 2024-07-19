<?php

namespace App\Http\Requests;

use App\Services\CommentLogger;
use App\Services\PostLogger;
use App\Services\RedirectService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreRequestComment extends FormRequest
{
    /**
     * Create a new form request instance.
     */
    public function __construct(
        protected CommentLogger $commentLogger,
        protected PostLogger $postLogger,
        protected RedirectService $redirectService,
    ) {}

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
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
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->post->slug) {
            $this->commentLogger->logCommentFailedDValidation($this->post, $validator->errors()->getMessages());

            throw ValidationException::withMessages(
                $validator->errors()->getMessages()
            )->redirectTo(route('posts.show', $this->post->slug).'#comments');
        }

        $this->postLogger->logPostNotFound('Unknown');

        return redirect()->to_route('404');
    }
}
