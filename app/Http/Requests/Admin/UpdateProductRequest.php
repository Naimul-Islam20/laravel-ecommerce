<?php

namespace App\Http\Requests\Admin;

class UpdateProductRequest extends ProductRequest
{
    public function rules(): array
    {
        return $this->productRules($this->route('product')?->id);
    }
}
