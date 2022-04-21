@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.peptideProtein.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.peptide-proteins.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.peptideProtein.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptideProtein.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="peptide_id">{{ trans('cruds.peptideProtein.fields.peptide') }}</label>
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
                <span class="help-block">{{ trans('cruds.peptideProtein.fields.peptide_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="protein_id">{{ trans('cruds.peptideProtein.fields.protein') }}</label>
                <select class="form-control select2 {{ $errors->has('protein') ? 'is-invalid' : '' }}" name="protein_id" id="protein_id">
                    @foreach($proteins as $id => $entry)
                        <option value="{{ $id }}" {{ old('protein_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('protein'))
                    <div class="invalid-feedback">
                        {{ $errors->first('protein') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptideProtein.fields.protein_helper') }}</span>
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