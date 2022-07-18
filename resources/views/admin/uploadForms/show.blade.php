@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.uploadForm.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.upload-forms.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-stripd">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.uploadForm.fields.id') }}
                            </th>
                            <td>
                                {{ $uploadForm->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.uploadForm.fields.project') }}
                            </th>
                            <td>
                                {{ $uploadForm->project->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.uploadForm.fields.experiment') }}
                            </th>
                            <td>
                                {{ $uploadForm->experiment->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.uploadForm.fields.psm_file') }}
                            </th>
                            <td>
                                @if ($uploadForm->psm_file)
                                    <a href="{{ $uploadForm->psm_file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.upload-forms.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
