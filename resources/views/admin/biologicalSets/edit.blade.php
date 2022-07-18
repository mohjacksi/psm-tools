@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.biologicalSet.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.biological-sets.update', [$biologicalSet->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">{{ trans('cruds.biologicalSet.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $biologicalSet->name) }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.biologicalSet.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="labeling_number">{{ trans('cruds.biologicalSet.fields.labeling_number') }}</label>
                    <input class="form-control {{ $errors->has('labeling_number') ? 'is-invalid' : '' }}" type="number"
                        name="labeling_number" id="labeling_number"
                        value="{{ old('labeling_number', $biologicalSet->labeling_number) }}" step="1">
                    @if ($errors->has('labeling_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('labeling_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.biologicalSet.fields.labeling_number_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                        for="experiments">{{ trans('cruds.biologicalSet.fields.experiment') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('experiments') ? 'is-invalid' : '' }}"
                        name="experiments[]" id="experiments" multiple required>
                        @foreach ($experiments as $id => $experiment)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('experiments', [])) || $biologicalSet->experiments->contains($id) ? 'selected' : '' }}>
                                {{ $experiment }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('experiments'))
                        <div class="invalid-feedback">
                            {{ $errors->first('experiments') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.biologicalSet.fields.experiment_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="strip_id">{{ trans('cruds.biologicalSet.fields.strip') }}</label>
                    <select class="form-control select2 {{ $errors->has('strip') ? 'is-invalid' : '' }}" name="strip_id"
                        id="strip_id">
                        @foreach ($strips as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('strip_id') ? old('strip_id') : $biologicalSet->strip->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('strip'))
                        <div class="invalid-feedback">
                            {{ $errors->first('strip') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.biologicalSet.fields.strip_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="fragment_method_id">{{ trans('cruds.biologicalSet.fields.fragment_method') }}</label>
                    <select class="form-control select2 {{ $errors->has('fragment_method') ? 'is-invalid' : '' }}"
                        name="fragment_method_id" id="fragment_method_id">
                        @foreach ($fragment_methods as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('fragment_method_id') ? old('fragment_method_id') : $biologicalSet->fragment_method->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('fragment_method'))
                        <div class="invalid-feedback">
                            {{ $errors->first('fragment_method') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.biologicalSet.fields.fragment_method_helper') }}</span>
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
