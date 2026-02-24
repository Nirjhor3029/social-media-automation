<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhatsappQueryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'whstapp_subscriber_id' => [
                'required',
                'integer',
            ],
            'question' => [
                'string',
                'required',
            ],
            'answer' => [
                'string',
                'required',
            ],
        ];
    }
}
