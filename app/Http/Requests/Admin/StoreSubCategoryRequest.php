<?php

namespace App\Http\Requests\Admin;

class StoreSubCategoryRequest extends SubCategoryRequest
{
    public function rules(): array
    {
        return $this->subCategoryRules();
    }
}
