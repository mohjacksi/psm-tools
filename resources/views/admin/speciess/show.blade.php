@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.species.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.speciess.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.species.fields.id') }}
                        </th>
                        <td>
                            {{ $species->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.species.fields.name') }}
                        </th>
                        <td>
                            {{ $species->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.speciess.index') }}">
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
            <a class="nav-link" href="#species_samples" role="tab" data-toggle="tab">
                {{ trans('cruds.sample.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#species_experiments" role="tab" data-toggle="tab">
                {{ trans('cruds.experiment.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="species_samples">
            @includeIf('admin.speciess.relationships.speciesSamples', ['samples' => $species->speciesSamples])
        </div>
        <div class="tab-pane" role="tabpanel" id="species_experiments">
            @includeIf('admin.speciess.relationships.speciesExperiments', ['experiments' => $species->speciesExperiments])
        </div>
    </div>
</div>

@endsection