@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.customer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.customers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.customer.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="whatsapp">{{ trans('cruds.customer.fields.whatsapp') }}</label>
                <input class="form-control {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', '') }}">
                @if($errors->has('whatsapp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.whatsapp_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="facebook">{{ trans('cruds.customer.fields.facebook') }}</label>
                <input class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}" type="text" name="facebook" id="facebook" value="{{ old('facebook', '') }}">
                @if($errors->has('facebook'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facebook') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.facebook_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="telegram">{{ trans('cruds.customer.fields.telegram') }}</label>
                <input class="form-control {{ $errors->has('telegram') ? 'is-invalid' : '' }}" type="text" name="telegram" id="telegram" value="{{ old('telegram', '') }}">
                @if($errors->has('telegram'))
                    <div class="invalid-feedback">
                        {{ $errors->first('telegram') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.telegram_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="instagram">{{ trans('cruds.customer.fields.instagram') }}</label>
                <input class="form-control {{ $errors->has('instagram') ? 'is-invalid' : '' }}" type="text" name="instagram" id="instagram" value="{{ old('instagram', '') }}">
                @if($errors->has('instagram'))
                    <div class="invalid-feedback">
                        {{ $errors->first('instagram') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.instagram_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tiktok">{{ trans('cruds.customer.fields.tiktok') }}</label>
                <input class="form-control {{ $errors->has('tiktok') ? 'is-invalid' : '' }}" type="text" name="tiktok" id="tiktok" value="{{ old('tiktok', '') }}">
                @if($errors->has('tiktok'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tiktok') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.tiktok_helper') }}</span>
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