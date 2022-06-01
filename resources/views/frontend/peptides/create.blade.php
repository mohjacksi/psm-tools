@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.peptide.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.peptides.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="sequence">{{ trans('cruds.peptide.fields.sequence') }}</label>
                            <input class="form-control" type="text" name="sequence" id="sequence" value="{{ old('sequence', '') }}">
                            @if($errors->has('sequence'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sequence') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.peptide.fields.sequence_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="canonical" value="0">
                                <input type="checkbox" name="canonical" id="canonical" value="1" {{ old('canonical', 0) == 1 ? 'checked' : '' }}>
                                <label for="canonical">{{ trans('cruds.peptide.fields.canonical') }}</label>
                            </div>
                            @if($errors->has('canonical'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('canonical') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.peptide.fields.canonical_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="canonical_frame_value">{{ trans('cruds.peptide.fields.canonical_frame_value') }}</label>
                            <textarea class="form-control" name="canonical_frame_value" id="canonical_frame_value">{{ old('canonical_frame_value') }}</textarea>
                            @if($errors->has('canonical_frame_value'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('canonical_frame_value') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.peptide.fields.canonical_frame_value_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="category_id">{{ trans('cruds.peptide.fields.category') }}</label>
                            <select class="form-control select2" name="category_id" id="category_id">
                                @foreach($categories as $id => $entry)
                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.peptide.fields.category_helper') }}</span>
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