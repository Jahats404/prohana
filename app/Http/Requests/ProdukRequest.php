<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
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
            'foto_produk' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|in:pria,wanita,anak',
            'jenis_produk' => 'required|in:sepatu,sandal,tas,jaket,sabuk',
            'harga' => 'required|integer|min:0',
        ];
    }

    /**
     * Get the custom validation messages for the rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'foto_produk.image' => 'Foto produk harus berupa gambar!',
            'foto_produk.mimes' => 'Foto produk harus berformat jpeg, png, jpg, gif, atau svg!',
            'foto_produk.max' => 'Foto produk tidak boleh lebih dari 2MB!',
            'nama_produk.required' => 'Nama produk tidak boleh kosong!',
            'kategori_produk.required' => 'Kategori produk tidak boleh kosong!',
            'kategori_produk.in' => 'Kategori produk harus pria, wanita, atau anak!',
            'jenis_produk.required' => 'Jenis produk tidak boleh kosong!',
            'jenis_produk.in' => 'Jenis produk harus sepatu, sandal, tas, jaket, atau sabuk!',
            'harga.required' => 'Harga produk tidak boleh kosong!',
            'harga.integer' => 'Harga produk harus berupa angka!',
            'harga.min' => 'Harga produk tidak boleh negatif!',
        ];
    }
}
