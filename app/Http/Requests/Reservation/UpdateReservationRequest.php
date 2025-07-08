<?php
namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service' => ['required', 'string'],
            'datetime' => ['required', 'date'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'customer_contact' => ['required', 'string'],
            'simple_questionnaire' => ['nullable', 'string'],
            'management_notes' => ['nullable', 'string'],
            'status' => ['sometimes', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'service.required' => 'Layanan wajib dipilih.',
            'datetime.required' => 'Tanggal dan waktu wajib diisi.',
            'datetime.date' => 'Format tanggal tidak valid.',
            'customer_contact.required' => 'Kontak customer wajib diisi.',
        ];
    }
}