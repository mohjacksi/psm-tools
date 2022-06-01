@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.transcript.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.transcripts.update", [$transcript->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="transcript">{{ trans('cruds.transcript.fields.transcript') }}</label>
                <input class="form-control {{ $errors->has('transcript') ? 'is-invalid' : '' }}" type="text" name="transcript" id="transcript" value="{{ old('transcript', $transcript->transcript) }}">
                @if($errors->has('transcript'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transcript') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.transcript_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.transcript.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $transcript->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.transcript.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Transcript::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $transcript->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="transcript_sequence">{{ trans('cruds.transcript.fields.transcript_sequence') }}</label>
                <input class="form-control {{ $errors->has('transcript_sequence') ? 'is-invalid' : '' }}" type="text" name="transcript_sequence" id="transcript_sequence" value="{{ old('transcript_sequence', $transcript->transcript_sequence) }}">
                @if($errors->has('transcript_sequence'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transcript_sequence') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.transcript_sequence_helper') }}</span>
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