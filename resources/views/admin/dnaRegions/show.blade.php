@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dnaRegion.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dna-regions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dnaRegion.fields.id') }}
                        </th>
                        <td>
                            {{ $dnaRegion->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dnaRegion.fields.name') }}
                        </th>
                        <td>
                            {{ $dnaRegion->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dna-regions.index') }}">
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
            <a class="nav-link" href="#dna_location_transcripts" role="tab" data-toggle="tab">
                {{ trans('cruds.transcript.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="dna_location_transcripts">
            @includeIf('admin.dnaRegions.relationships.dnaLocationTranscripts', ['transcripts' => $dnaRegion->dnaLocationTranscripts])
        </div>
    </div>
</div>

@endsection