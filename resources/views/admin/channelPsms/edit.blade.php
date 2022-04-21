@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.channelPsm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.channel-psms.update", [$channelPsm->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="value">{{ trans('cruds.channelPsm.fields.value') }}</label>
                <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="text" name="value" id="value" value="{{ old('value', $channelPsm->value) }}">
                @if($errors->has('value'))
                    <div class="invalid-feedback">
                        {{ $errors->first('value') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.channelPsm.fields.value_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="channel_id">{{ trans('cruds.channelPsm.fields.channel') }}</label>
                <select class="form-control select2 {{ $errors->has('channel') ? 'is-invalid' : '' }}" name="channel_id" id="channel_id">
                    @foreach($channels as $id => $entry)
                        <option value="{{ $id }}" {{ (old('channel_id') ? old('channel_id') : $channelPsm->channel->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('channel'))
                    <div class="invalid-feedback">
                        {{ $errors->first('channel') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.channelPsm.fields.channel_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="psm_id">{{ trans('cruds.channelPsm.fields.psm') }}</label>
                <select class="form-control select2 {{ $errors->has('psm') ? 'is-invalid' : '' }}" name="psm_id" id="psm_id">
                    @foreach($psms as $id => $entry)
                        <option value="{{ $id }}" {{ (old('psm_id') ? old('psm_id') : $channelPsm->psm->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('psm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('psm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.channelPsm.fields.psm_helper') }}</span>
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