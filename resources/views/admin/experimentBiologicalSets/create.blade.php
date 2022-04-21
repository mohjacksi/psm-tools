@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.experimentBiologicalSet.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.experiment-biological-sets.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.experimentBiologicalSet.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experimentBiologicalSet.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="set">{{ trans('cruds.experimentBiologicalSet.fields.set') }}</label>
                <input class="form-control {{ $errors->has('set') ? 'is-invalid' : '' }}" type="text" name="set" id="set" value="{{ old('set', '') }}">
                @if($errors->has('set'))
                    <div class="invalid-feedback">
                        {{ $errors->first('set') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experimentBiologicalSet.fields.set_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experiment_id">{{ trans('cruds.experimentBiologicalSet.fields.experiment') }}</label>
                <select class="form-control select2 {{ $errors->has('experiment') ? 'is-invalid' : '' }}" name="experiment_id" id="experiment_id">
                    @foreach($experiments as $id => $entry)
                        <option value="{{ $id }}" {{ old('experiment_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('experiment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experiment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experimentBiologicalSet.fields.experiment_helper') }}</span>
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