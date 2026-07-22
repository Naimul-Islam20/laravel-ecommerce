<?php

namespace App\Http\Requests\Admin;

class UpdateAdminRequest extends AdminUserRequest
{
    public function rules(): array
    {
        return $this->adminRules($this->route('admin')?->id);
    }
}
