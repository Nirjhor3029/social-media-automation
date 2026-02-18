<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_create');
    }

    public function rules()
    {
        return [
            'whatsapp' => [
                'string',
                'nullable',
            ],
            'facebook' => [
                'string',
                'nullable',
            ],
            'telegram' => [
                'string',
                'nullable',
            ],
            'instagram' => [
                'string',
                'nullable',
            ],
            'tiktok' => [
                'string',
                'nullable',
            ],
        ];
    }
}
