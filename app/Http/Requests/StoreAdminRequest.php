<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|min:5|confirmed',
            'role'     => 'nullable',
        ];
    }

    /**
     * Attributes .
     *
     * @return array
     */
    public function attributes()
    {
        return [            
            'name'     => __('lang.name'),
            'email'    => __('lang.email'),
            'password' => __('lang.password'),
            'role'     => __('lang.role'),
        ];
    }
}
