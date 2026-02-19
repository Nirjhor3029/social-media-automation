<?php

namespace App\Http\Requests;

use App\Models\WhstappSubscriber;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWhstappSubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whstapp_subscriber_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'phone' => [
                'string',
                'required',
                'unique:whstapp_subscribers',
            ],
        ];
    }
}
