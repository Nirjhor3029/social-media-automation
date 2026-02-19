<?php

namespace App\Http\Requests;

use App\Models\Temnplate;
Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTemnplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('temnplate_edit');
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
