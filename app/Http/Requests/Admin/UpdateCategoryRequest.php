<?php

namespace App\Http\Requests\Admin;

class UpdateCategoryRequest extends CategoryRequest
{
    public function rules(): array
    {
        return $this->categoryRules($this->route('category')?->id);
    }
}
