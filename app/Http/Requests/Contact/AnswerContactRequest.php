<?php
namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class AnswerContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answer_title' => ['required', 'string', 'max:255'],
            'answer_text' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'answer_title.required' => 'Judul jawaban wajib diisi.',
            'answer_title.max' => 'Judul maksimal 255 karakter.',
            'answer_text.required' => 'Isi jawaban wajib diisi.',
        ];
    }
}