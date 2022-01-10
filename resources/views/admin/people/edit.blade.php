@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.person.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.people.update", [$person->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="patient_name">{{ trans('cruds.person.fields.patient_name') }}</label>
                <input class="form-control {{ $errors->has('patient_name') ? 'is-invalid' : '' }}" type="text" name="patient_name" id="patient_name" value="{{ old('patient_name', $person->patient_name) }}">
                @if($errors->has('patient_name'))
                    <span class="text-danger">{{ $errors->first('patient_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.patient_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="birth_date">{{ trans('cruds.person.fields.birth_date') }}</label>
                <input class="form-control date {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="text" name="birth_date" id="birth_date" value="{{ old('birth_date', $person->birth_date) }}">
                @if($errors->has('birth_date'))
                    <span class="text-danger">{{ $errors->first('birth_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.birth_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.person.fields.sex') }}</label>
                @foreach(App\Models\Person::SEX_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('sex') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="sex_{{ $key }}" name="sex" value="{{ $key }}" {{ old('sex', $person->sex) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="sex_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('sex'))
                    <span class="text-danger">{{ $errors->first('sex') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.sex_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.person.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $entry)
                        <option value="{{ $id }}" {{ (old('project_id') ? old('project_id') : $person->project->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('project'))
                    <span class="text-danger">{{ $errors->first('project') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.person.fields.project_helper') }}</span>
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