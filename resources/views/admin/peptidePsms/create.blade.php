@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.peptidePsm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.peptide-psms.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.peptidePsm.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptidePsm.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="peptide_id">{{ trans('cruds.peptidePsm.fields.peptide') }}</label>
                <select class="form-control select2 {{ $errors->has('peptide') ? 'is-invalid' : '' }}" name="peptide_id" id="peptide_id">
                    @foreach($peptides as $id => $entry)
                        <option value="{{ $id }}" {{ old('peptide_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('peptide'))
                    <div class="invalid-feedback">
                        {{ $errors->first('peptide') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptidePsm.fields.peptide_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="psm_id">{{ trans('cruds.peptidePsm.fields.psm') }}</label>
                <select class="form-control select2 {{ $errors->has('psm') ? 'is-invalid' : '' }}" name="psm_id" id="psm_id">
                    @foreach($psms as $id => $entry)
                        <option value="{{ $id }}" {{ old('psm_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('psm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('psm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptidePsm.fields.psm_helper') }}</span>
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