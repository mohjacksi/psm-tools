@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.peptideWithModification.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptide-with-modifications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.peptideWithModification.fields.id') }}
                        </th>
                        <td>
                            {{ $peptideWithModification->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptideWithModification.fields.name') }}
                        </th>
                        <td>
                            {{ $peptideWithModification->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptide-with-modifications.index') }}">
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
            <a class="nav-link" href="#peptide_with_modification_psms" role="tab" data-toggle="tab">
                {{ trans('cruds.psm.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="peptide_with_modification_psms">
            @includeIf('admin.peptideWithModifications.relationships.peptideWithModificationPsms', ['psms' => $peptideWithModification->peptideWithModificationPsms])
        </div>
    </div>
</div>

@endsection