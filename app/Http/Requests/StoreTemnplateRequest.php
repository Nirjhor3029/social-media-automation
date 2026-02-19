<?php

namespace App\Http\Requests;

use App\Models\Temnplate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTemnplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('temnplate_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
        ];
    }
}
