<?php

namespace App\Http\Requests\Admin;

class StoreProductRequest extends ProductRequest
{
    public function rules(): array
    {
        return $this->productRules();
    }
}
