<?php

namespace App\Http\Requests\Admin;

class StoreAdminRequest extends AdminUserRequest
{
    public function rules(): array
    {
        return $this->adminRules();
    }
}
