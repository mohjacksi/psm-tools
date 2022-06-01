@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.channel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.channels.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.channel.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="biological_set_id">{{ trans('cruds.channel.fields.biological_set') }}</label>
                <select class="form-control select2 {{ $errors->has('biological_set') ? 'is-invalid' : '' }}" name="biological_set_id" id="biological_set_id">
                    @foreach($biological_sets as $id => $entry)
                        <option value="{{ $id }}" {{ old('biological_set_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('biological_set'))
                    <div class="invalid-feedback">
                        {{ $errors->first('biological_set') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.channel.fields.biological_set_helper') }}</span>
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