<?php

namespace App\Http\Requests;

use App\Models\WhstappSubscriber;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWhstappSubscriberRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('whstapp_subscriber_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:whstapp_subscribers,id',
        ];
    }
}
