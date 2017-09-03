<?php namespace CleanSoft\Modules\Core\Http\Requests;

class CreateRoleRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
            'slug' => 'required|max:255|alpha_dash',
        ];
    }
}
