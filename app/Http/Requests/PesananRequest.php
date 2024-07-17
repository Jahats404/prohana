<?php

namespace App\Http\Requests;

use App\Models\Pesanan;
use Illuminate\Foundation\Http\FormRequest;

class PesananRequest extends FormRequest
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
            'produk_id' => 'required|integer',
            'tanggal_pesan' => 'required|date',
            'status_pesanan' => 'required|in:pending,accepted,rejected',
            'total_harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'produk_id.required' => 'Produk wajib diisi.',
            'tanggal_pesan.required' => 'Tanggal pesan wajib diisi.',
            'status_pesanan.required' => 'Status pesanan wajib diisi.',
            'total_harga.required' => 'Total harga wajib diisi.',
            'produk_id.integer' => 'Produk harus berupa angka.',
            'agen_id.integer' => 'Agen harus berupa angka.',
            'status_pesanan.in' => 'Status pesanan harus pending, accepted, atau rejected.',
            'total_harga.numeric' => 'Total harga harus berupa angka.',
            'jumlah.required' => 'Jumlah produk wajib diisi.',
            'jumlah.integer' => 'Jumlah produk harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah produk tidak boleh kurang dari 0.',
        ];
    }
}
