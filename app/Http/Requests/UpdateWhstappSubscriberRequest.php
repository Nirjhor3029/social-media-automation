<?php

namespace App\Http\Requests;

use App\Models\WhstappSubscriber;
Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWhstappSubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whstapp_subscriber_edit');
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
                'unique:whstapp_subscribers,phone,' . request()->route('whstapp_subscriber')->id,
            ],
        ];
    }
}
