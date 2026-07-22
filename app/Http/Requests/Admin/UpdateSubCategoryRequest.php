<?php

namespace App\Http\Requests\Admin;

class UpdateSubCategoryRequest extends SubCategoryRequest
{
    public function rules(): array
    {
        return $this->subCategoryRules($this->route('subcategory')?->id);
    }
}
