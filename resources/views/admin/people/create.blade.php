@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.person.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.people.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.person.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="birth_date">{{ trans('cruds.person.fields.birth_date') }}</label>
                <input class="form-control date {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="text" name="birth_date" id="birth_date" value="{{ old('birth_date') }}">
                @if($errors->has('birth_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('birth_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.birth_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.person.fields.sex') }}</label>
                @foreach(App\Models\Person::SEX_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('sex') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="sex_{{ $key }}" name="sex" value="{{ $key }}" {{ old('sex', '') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="sex_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('sex'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sex') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.sex_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.person.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $entry)
                        <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('project'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="projects_id">{{ trans('cruds.person.fields.projects') }}</label>
                <select class="form-control select2 {{ $errors->has('projects') ? 'is-invalid' : '' }}" name="projects_id" id="projects_id">
                    @foreach($projects as $id => $entry)
                        <option value="{{ $id }}" {{ old('projects_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('projects'))
                    <div class="invalid-feedback">
                        {{ $errors->first('projects') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.projects_helper') }}</span>
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