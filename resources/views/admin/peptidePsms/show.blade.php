@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.peptidePsm.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptide-psms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.peptidePsm.fields.id') }}
                        </th>
                        <td>
                            {{ $peptidePsm->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptidePsm.fields.name') }}
                        </th>
                        <td>
                            {{ $peptidePsm->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptidePsm.fields.peptide') }}
                        </th>
                        <td>
                            {{ $peptidePsm->peptide->sequence ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptidePsm.fields.psm') }}
                        </th>
                        <td>
                            {{ $peptidePsm->psm->spectra ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptide-psms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection