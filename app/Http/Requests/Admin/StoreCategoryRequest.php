<?php

namespace App\Http\Requests\Admin;

class StoreCategoryRequest extends CategoryRequest
{
    public function rules(): array
    {
        return $this->categoryRules();
    }
}
