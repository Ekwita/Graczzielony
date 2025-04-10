<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoteRequest extends FormRequest
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
            'username' => 'required|string|unique:votes,user_name',
            // 'email' => 'required|email',
            'votes' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => 'Użytkownik o tej nazwie już głosował.',
            'username.required' => 'Nazwa użytkownika jest wymagana.',
            'votes.required' => 'Musisz wybrać trzy gry.',
        ];
    }
}
