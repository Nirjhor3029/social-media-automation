@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.whatsappGroup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.whatsapp-groups.update", [$whatsappGroup->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="whstapp_subscriber_id">{{ trans('cruds.whatsappGroup.fields.whstapp_subscriber') }}</label>
                <select class="form-control select2 {{ $errors->has('whstapp_subscriber') ? 'is-invalid' : '' }}" name="whstapp_subscriber_id" id="whstapp_subscriber_id" required>
                    @foreach($whstapp_subscribers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('whstapp_subscriber_id') ? old('whstapp_subscriber_id') : $whatsappGroup->whstapp_subscriber->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('whstapp_subscriber'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whstapp_subscriber') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappGroup.fields.whstapp_subscriber_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.whatsappGroup.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $whatsappGroup->title) }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappGroup.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection