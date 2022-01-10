@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.psm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.psms.update", [$psm->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="psm_info">{{ trans('cruds.psm.fields.psm_info') }}</label>
                <input class="form-control {{ $errors->has('psm_info') ? 'is-invalid' : '' }}" type="text" name="psm_info" id="psm_info" value="{{ old('psm_info', $psm->psm_info) }}">
                @if($errors->has('psm_info'))
                    <span class="text-danger">{{ $errors->first('psm_info') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.psm_info_helper') }}</span>
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