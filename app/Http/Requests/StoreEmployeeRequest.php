<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; } // Izinkan semua
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'position' => 'required|string|max:255',
            'division_id' => 'required|uuid|exists:divisions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ];
    }
}
