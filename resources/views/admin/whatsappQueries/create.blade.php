@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Create Whatsapp Query
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.whatsapp-queries.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="whstapp_subscriber_id">Whatsapp Subscriber</label>
                    <select class="form-control select2 {{ $errors->has('whstapp_subscriber') ? 'is-invalid' : '' }}"
                        name="whstapp_subscriber_id" id="whstapp_subscriber_id" required>
                        @foreach($whstapp_subscribers as $id => $entry)
                            <option value="{{ $id }}" {{ old('whstapp_subscriber_id') == $id ? 'selected' : '' }}>{{ $entry }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('whstapp_subscriber'))
                        <div class="invalid-feedback">
                            {{ $errors->first('whstapp_subscriber') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="question">Question</label>
                    <input class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" type="text"
                        name="question" id="question" value="{{ old('question', '') }}" required>
                    @if($errors->has('question'))
                        <div class="invalid-feedback">
                            {{ $errors->first('question') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="answer">Answer</label>
                    <textarea class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}" name="answer"
                        id="answer" required>{{ old('answer') }}</textarea>
                    @if($errors->has('answer'))
                        <div class="invalid-feedback">
                            {{ $errors->first('answer') }}
                        </div>
                    @endif
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