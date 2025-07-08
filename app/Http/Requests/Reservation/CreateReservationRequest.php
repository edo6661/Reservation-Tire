<?php
namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service' => ['required', 'string'],
            'datetime' => ['required', 'date', 'after:now'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'customer_contact' => ['required', 'string'],
            'simple_questionnaire' => ['nullable', 'string'],
            'customer_id' => ['sometimes', 'exists:customers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'service.required' => 'Layanan wajib dipilih.',
            'datetime.required' => 'Tanggal dan waktu wajib diisi.',
            'datetime.date' => 'Format tanggal tidak valid.',
            'datetime.after' => 'Tanggal harus setelah waktu sekarang.',
            'customer_contact.required' => 'Kontak customer wajib diisi.',
            'customer_id.exists' => 'Customer tidak ditemukan.',
        ];
    }
}