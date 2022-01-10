@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.transcript.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.transcripts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="transcript">{{ trans('cruds.transcript.fields.transcript') }}</label>
                <input class="form-control {{ $errors->has('transcript') ? 'is-invalid' : '' }}" type="text" name="transcript" id="transcript" value="{{ old('transcript', '') }}">
                @if($errors->has('transcript'))
                    <span class="text-danger">{{ $errors->first('transcript') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.transcript_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.transcript.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.transcript.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Transcript::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dna_location_id">{{ trans('cruds.transcript.fields.dna_location') }}</label>
                <select class="form-control select2 {{ $errors->has('dna_location') ? 'is-invalid' : '' }}" name="dna_location_id" id="dna_location_id">
                    @foreach($dna_locations as $id => $entry)
                        <option value="{{ $id }}" {{ old('dna_location_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('dna_location'))
                    <span class="text-danger">{{ $errors->first('dna_location') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.transcript.fields.dna_location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="transcript_sequence">{{ trans('cruds.transcript.fields.transcript_sequence') }}</label>
                <input class="form-control {{ $errors->has('transcript_sequence') ? 'is-invalid' : '' }}" type="text" name="transcript_sequence" id="transcript_sequence" value="{{ old('transcript_sequence', '') }}">
                @if($errors->has('transcript_sequence'))
                    <span class="text-danger">{{ $errors->first('transcript_sequence') }}</span>
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