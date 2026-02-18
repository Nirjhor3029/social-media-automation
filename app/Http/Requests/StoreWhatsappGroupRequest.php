<?php

namespace App\Http\Requests;

use App\Models\WhatsappGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWhatsappGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whatsapp_group_create');
    }

    public function rules()
    {
        return [
            'whstapp_subscriber_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'string',
                'nullable',
            ],
        ];
    }
}
