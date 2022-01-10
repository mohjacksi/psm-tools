@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.protein.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.proteins.update", [$protein->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="protein">{{ trans('cruds.protein.fields.protein') }}</label>
                <input class="form-control {{ $errors->has('protein') ? 'is-invalid' : '' }}" type="text" name="protein" id="protein" value="{{ old('protein', $protein->protein) }}">
                @if($errors->has('protein'))
                    <span class="text-danger">{{ $errors->first('protein') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.protein.fields.protein_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.protein.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $protein->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.protein.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.protein.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Protein::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $protein->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.protein.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="protein_sequence">{{ trans('cruds.protein.fields.protein_sequence') }}</label>
                <input class="form-control {{ $errors->has('protein_sequence') ? 'is-invalid' : '' }}" type="text" name="protein_sequence" id="protein_sequence" value="{{ old('protein_sequence', $protein->protein_sequence) }}">
                @if($errors->has('protein_sequence'))
                    <span class="text-danger">{{ $errors->first('protein_sequence') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.protein.fields.protein_sequence_helper') }}</span>
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