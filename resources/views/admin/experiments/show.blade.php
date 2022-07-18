@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.experiment.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.experiments.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-stripd">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.id') }}
                            </th>
                            <td>
                                {{ $experiment->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.name') }}
                            </th>
                            <td>
                                {{ $experiment->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.project') }}
                            </th>
                            <td>
                                {{ $experiment->project->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.date') }}
                            </th>
                            <td>
                                {{ $experiment->date }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.method') }}
                            </th>
                            <td>
                                {{ App\Models\Experiment::METHOD_SELECT[$experiment->method] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.allowed_missed_cleavage') }}
                            </th>
                            <td>
                                <input type="checkbox" disabled="disabled"
                                    {{ $experiment->allowed_missed_cleavage ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.expression_threshold') }}
                            </th>
                            <td>
                                {{ $experiment->expression_threshold }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.species') }}
                            </th>
                            <td>
                                {{ $experiment->species->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.reference_protein_source') }}
                            </th>
                            <td>
                                {{ $experiment->reference_protein_source }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.other_protein_source') }}
                            </th>
                            <td>
                                {{ $experiment->other_protein_source }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.psm_file_name') }}
                            </th>
                            <td>
                                {{ $experiment->psm_file_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.experiment.fields.metadata') }}
                            </th>
                            <td>
                                {!! $experiment->metadata !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.experiments.index') }}">
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
                <a class="nav-link" href="#experiment_upload_forms" role="tab" data-toggle="tab">
                    {{ trans('cruds.uploadForm.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#experiment_biological_sets" role="tab" data-toggle="tab">
                    {{ trans('cruds.biologicalSet.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="experiment_upload_forms">
                @includeIf('admin.experiments.relationships.experimentUploadForms', [
                    'uploadForms' => $experiment->experimentUploadForms,
                ])
            </div>
            <div class="tab-pane" role="tabpanel" id="experiment_biological_sets">
                @includeIf('admin.experiments.relationships.experimentBiologicalSets', [
                    'biologicalSets' => $experiment->experimentBiologicalSets,
                ])
            </div>
        </div>
    </div>
@endsection
