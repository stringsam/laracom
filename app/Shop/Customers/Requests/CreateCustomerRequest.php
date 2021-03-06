<?php

namespace App\Shop\Customers\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateCustomerRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:customers'],
            'company' => ['string'],
            'ico' => ['integer'],
            'dic' => ['string'],
            'password' => ['nullable', 'min:8'],
            'groups' => ['array', 'nullable'],
            'status' => ['nullable', 'integer']
        ];
    }
}
