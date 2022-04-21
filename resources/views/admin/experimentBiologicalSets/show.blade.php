@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.experimentBiologicalSet.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.experiment-biological-sets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.experimentBiologicalSet.fields.id') }}
                        </th>
                        <td>
                            {{ $experimentBiologicalSet->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.experimentBiologicalSet.fields.name') }}
                        </th>
                        <td>
                            {{ $experimentBiologicalSet->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.experimentBiologicalSet.fields.set') }}
                        </th>
                        <td>
                            {{ $experimentBiologicalSet->set }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.experimentBiologicalSet.fields.experiment') }}
                        </th>
                        <td>
                            {{ $experimentBiologicalSet->experiment->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.experiment-biological-sets.index') }}">
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
            <a class="nav-link" href="#experiment_biological_set_biological_sets" role="tab" data-toggle="tab">
                {{ trans('cruds.biologicalSet.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="experiment_biological_set_biological_sets">
            @includeIf('admin.experimentBiologicalSets.relationships.experimentBiologicalSetBiologicalSets', ['biologicalSets' => $experimentBiologicalSet->experimentBiologicalSetBiologicalSets])
        </div>
    </div>
</div>

@endsection