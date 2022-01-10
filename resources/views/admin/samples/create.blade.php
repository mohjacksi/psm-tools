@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sample.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.samples.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="sample">{{ trans('cruds.sample.fields.sample') }}</label>
                <input class="form-control {{ $errors->has('sample') ? 'is-invalid' : '' }}" type="text" name="sample" id="sample" value="{{ old('sample', '') }}">
                @if($errors->has('sample'))
                    <span class="text-danger">{{ $errors->first('sample') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.sample_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.sample.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.sample.fields.sample_type') }}</label>
                <select class="form-control {{ $errors->has('sample_type') ? 'is-invalid' : '' }}" name="sample_type" id="sample_type">
                    <option value disabled {{ old('sample_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Sample::SAMPLE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('sample_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('sample_type'))
                    <span class="text-danger">{{ $errors->first('sample_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.sample_type_helper') }}</span>
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