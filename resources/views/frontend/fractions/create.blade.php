@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.fraction.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.fractions.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.fraction.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.fraction.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="biological_set_id">{{ trans('cruds.fraction.fields.biological_set') }}</label>
                            <select class="form-control select2" name="biological_set_id" id="biological_set_id">
                                @foreach($biological_sets as $id => $entry)
                                    <option value="{{ $id }}" {{ old('biological_set_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('biological_set'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('biological_set') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.fraction.fields.biological_set_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="spectra_file_name">{{ trans('cruds.fraction.fields.spectra_file_name') }}</label>
                            <input class="form-control" type="text" name="spectra_file_name" id="spectra_file_name" value="{{ old('spectra_file_name', '') }}">
                            @if($errors->has('spectra_file_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('spectra_file_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.fraction.fields.spectra_file_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection