<?php

namespace App\Http\Requests\Inventory;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');
        $uniqueName = Rule::unique('categories', 'name');
        if ($category instanceof Category) {
            $uniqueName->ignore($category);
        }

        return [
            'name' => ['required', 'string', 'max:150', $uniqueName],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
