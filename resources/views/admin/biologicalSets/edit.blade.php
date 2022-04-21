@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.biologicalSet.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.biological-sets.update", [$biologicalSet->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.biologicalSet.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $biologicalSet->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.biologicalSet.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experiment_biological_set_id">{{ trans('cruds.biologicalSet.fields.experiment_biological_set') }}</label>
                <select class="form-control select2 {{ $errors->has('experiment_biological_set') ? 'is-invalid' : '' }}" name="experiment_biological_set_id" id="experiment_biological_set_id">
                    @foreach($experiment_biological_sets as $id => $entry)
                        <option value="{{ $id }}" {{ (old('experiment_biological_set_id') ? old('experiment_biological_set_id') : $biologicalSet->experiment_biological_set->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('experiment_biological_set'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experiment_biological_set') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.biologicalSet.fields.experiment_biological_set_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="stripe_id">{{ trans('cruds.biologicalSet.fields.stripe') }}</label>
                <select class="form-control select2 {{ $errors->has('stripe') ? 'is-invalid' : '' }}" name="stripe_id" id="stripe_id">
                    @foreach($stripes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('stripe_id') ? old('stripe_id') : $biologicalSet->stripe->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('stripe'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stripe') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.biologicalSet.fields.stripe_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fragment_method_id">{{ trans('cruds.biologicalSet.fields.fragment_method') }}</label>
                <select class="form-control select2 {{ $errors->has('fragment_method') ? 'is-invalid' : '' }}" name="fragment_method_id" id="fragment_method_id">
                    @foreach($fragment_methods as $id => $entry)
                        <option value="{{ $id }}" {{ (old('fragment_method_id') ? old('fragment_method_id') : $biologicalSet->fragment_method->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('fragment_method'))
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