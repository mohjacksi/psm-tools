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
            <table class="table table-bordered table-striped">
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
            <a class="nav-link" href="#project_people" role="tab" data-toggle="tab">
                {{ trans('cruds.person.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#projects_people" role="tab" data-toggle="tab">
                {{ trans('cruds.person.title') }}
            </a>
        </li>
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
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="project_people">
            @includeIf('admin.projects.relationships.projectPeople', ['people' => $project->projectPeople])
        </div>
        <div class="tab-pane" role="tabpanel" id="projects_people">
            @includeIf('admin.projects.relationships.projectsPeople', ['people' => $project->projectsPeople])
        </div>
        <div class="tab-pane" role="tabpanel" id="project_samples">
            @includeIf('admin.projects.relationships.projectSamples', ['samples' => $project->projectSamples])
        </div>
        <div class="tab-pane" role="tabpanel" id="project_experiments">
            @includeIf('admin.projects.relationships.projectExperiments', ['experiments' => $project->projectExperiments])
        </div>
    </div>
</div>

@endsection