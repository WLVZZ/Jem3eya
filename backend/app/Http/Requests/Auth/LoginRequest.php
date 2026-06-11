<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:190'],
            'password' => ['required', 'string', 'max:190'],
            'captcha_token' => ['nullable', 'string', 'max:1000'],
            'otp_code' => ['nullable', 'string', 'max:20'],
        ];
    }
}
