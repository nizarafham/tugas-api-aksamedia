<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
         return [
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string',
            'position' => 'sometimes|string|max:255',
            'division_id' => 'sometimes|uuid|exists:divisions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
