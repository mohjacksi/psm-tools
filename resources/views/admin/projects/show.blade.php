@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.project.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-stripd">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.id') }}
                            </th>
                            <td>
                                {{ $project->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.name') }}
                            </th>
                            <td>
                                {{ $project->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.description') }}
                            </th>
                            <td>
                                {!! $project->description !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.public') }}
                            </th>
                            <td>
                                <input type="checkbox" disabled="disabled" {{ $project->public ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.created_by') }}
                            </th>
                            <td>
                                {{ $project->created_by->name ?? '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#project_samples" role="tab" data-toggle="tab">
                    {{ trans('cruds.sample.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#project_experiments" role="tab" data-toggle="tab">
                    {{ trans('cruds.experiment.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#project_upload_forms" role="tab" data-toggle="tab">
                    {{ trans('cruds.uploadForm.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="project_samples">
                @includeIf('admin.projects.relationships.projectSamples', [
                    'samples' => $project->projectSamples,
                ])
            </div>
            <div class="tab-pane" role="tabpanel" id="project_experiments">
                @includeIf('admin.projects.relationships.projectExperiments', [
                    'experiments' => $project->projectExperiments,
                ])
            </div>
            <div class="tab-pane" role="tabpanel" id="project_upload_forms">
                @includeIf('admin.projects.relationships.projectUploadForms', [
                    'uploadForms' => $project->projectUploadForms,
                ])
            </div>
        </div>
    </div>
@endsection
