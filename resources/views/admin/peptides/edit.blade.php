@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.peptide.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.peptides.update", [$peptide->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="sequence">{{ trans('cruds.peptide.fields.sequence') }}</label>
                <input class="form-control {{ $errors->has('sequence') ? 'is-invalid' : '' }}" type="text" name="sequence" id="sequence" value="{{ old('sequence', $peptide->sequence) }}">
                @if($errors->has('sequence'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sequence') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptide.fields.sequence_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="genomic_location">{{ trans('cruds.peptide.fields.genomic_location') }}</label>
                <input class="form-control {{ $errors->has('genomic_location') ? 'is-invalid' : '' }}" type="text" name="genomic_location" id="genomic_location" value="{{ old('genomic_location', $peptide->genomic_location) }}">
                @if($errors->has('genomic_location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('genomic_location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptide.fields.genomic_location_helper') }}</span>
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