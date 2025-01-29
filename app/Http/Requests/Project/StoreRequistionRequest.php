<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequistionRequest extends FormRequest
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
            'requistion_page' => 'nullable|string',
            'project_id' => 'required|integer',
            'requisitionCategoryId' => 'required|integer',
            'amount' => 'required|numeric',
            'name' => 'required|string|max:256|unique:requistions,name',
            'description' => 'required|string|max:2555',
        ];
    }
}
