<?php namespace CleanSoft\Modules\Core\Http\Requests;

class UpdateRoleRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
        ];
    }
}
