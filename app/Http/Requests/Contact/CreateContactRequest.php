<?php
namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'sender' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul pesan wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'text.required' => 'Isi pesan wajib diisi.',
            'sender.required' => 'Email pengirim wajib diisi.',
            'sender.email' => 'Format email tidak valid.',
        ];
    }
}