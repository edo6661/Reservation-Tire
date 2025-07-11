<?php
namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'password' => ['nullable', 'confirmed', 'min:8', Password::defaults()],
            'password_confirmation' => ['nullable', 'same:password'],
        ];
    }
    protected function prepareForValidation()
    {
        if (empty($this->password)) {
            $this->merge([
                'password' => null,
                'password_confirmation' => null,
            ]);
        }
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            
        ];
    }
}