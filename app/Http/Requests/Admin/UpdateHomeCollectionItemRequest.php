<?php

namespace App\Http\Requests\Admin;

use App\Models\HomeCollectionItem;

class UpdateHomeCollectionItemRequest extends HomeCollectionItemRequest
{
    public function rules(): array
    {
        /** @var HomeCollectionItem|null $item */
        $item = $this->route('home_collection_item');

        return $this->itemRules($item?->id);
    }
}
