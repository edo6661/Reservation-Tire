<?php

namespace App\Http\Requests\Reservation;

use App\Models\ReservationAvailability;
use Carbon\Carbon;
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->datetime) {
                $datetime = Carbon::parse($this->datetime);
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('H:i');
                
                if (!ReservationAvailability::isSlotAvailable($date, $time)) {
                    $validator->errors()->add('datetime', 'Slot waktu yang dipilih tidak tersedia atau sudah dipesan.');
                }
            }
        });
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