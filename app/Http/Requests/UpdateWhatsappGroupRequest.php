<?php

namespace App\Http\Requests;

use App\Models\WhatsappGroup;
Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWhatsappGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whatsapp_group_edit');
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
