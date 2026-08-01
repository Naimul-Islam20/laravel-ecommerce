<?php

namespace App\Http\Requests\Admin;

class StoreHomeCollectionItemRequest extends HomeCollectionItemRequest
{
    public function rules(): array
    {
        return $this->itemRules();
    }
}
