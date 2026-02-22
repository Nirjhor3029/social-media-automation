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
                    <div class="form-group">
                        <label for="name">{{ trans('cruds.customer.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                            id="name" value="{{ old('name', '') }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.customer.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">{{ trans('cruds.customer.fields.whatsapp') }}</label>
                        <input class="form-control {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" type="text"
                            name="whatsapp" id="whatsapp" value="{{ old('whatsapp', '') }}">
                        @if($errors->has('whatsapp'))
                            <div class="invalid-feedback">
                                {{ $errors->first('whatsapp') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.customer.fields.whatsapp_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="facebook">{{ trans('cruds.customer.fields.facebook') }}</label>
                        <input class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}" type="text"
                            name="facebook" id="facebook" value="{{ old('facebook', '') }}">
                        @if($errors->has('facebook'))
                            <div class="invalid-feedback">
                                {{ $errors->first('facebook') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.customer.fields.facebook_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="telegram">{{ trans('cruds.customer.fields.telegram') }}</label>
                        <input class="form-control {{ $errors->has('telegram') ? 'is-invalid' : '' }}" type="text"
                            name="telegram" id="telegram" value="{{ old('telegram', '') }}">
                        @if($errors->has('telegram'))
                            <div class="invalid-feedback">
                                {{ $errors->first('telegram') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.customer.fields.telegram_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="instagram">{{ trans('cruds.customer.fields.instagram') }}</label>
                        <input class="form-control {{ $errors->has('instagram') ? 'is-invalid' : '' }}" type="text"
                            name="instagram" id="instagram" value="{{ old('instagram', '') }}">
                        @if($errors->has('instagram'))
                            <div class="invalid-feedback">
                                {{ $errors->first('instagram') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.customer.fields.instagram_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="tiktok">{{ trans('cruds.customer.fields.tiktok') }}</label>
                        <input class="form-control {{ $errors->has('tiktok') ? 'is-invalid' : '' }}" type="text"
                            name="tiktok" id="tiktok" value="{{ old('tiktok', '') }}">
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