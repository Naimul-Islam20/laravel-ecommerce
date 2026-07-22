<?php

namespace App\Http\Requests\Admin;

use App\Models\HomeSection;
use Illuminate\Validation\Rule;

class UpdateHomeSectionRequest extends StoreHomeSectionRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $sectionId = $this->route('home_section')?->id;
        $catalogTypes = [HomeSection::TYPE_CATEGORY, HomeSection::TYPE_SUBCATEGORY];

        $rules['slug'] = [
            'nullable',
            'string',
            'max:255',
            Rule::unique('home_sections', 'slug')->ignore($sectionId),
        ];

        $rules['category_id'] = [
            Rule::requiredIf(fn () => in_array($this->input('type'), $catalogTypes, true)),
            'nullable',
            'integer',
            Rule::exists('categories', 'id'),
            Rule::unique('home_sections', 'category_id')
                ->where(fn ($query) => $query->whereIn('type', $catalogTypes))
                ->ignore($sectionId),
        ];

        return $rules;
    }
}
