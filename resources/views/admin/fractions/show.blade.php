@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fraction.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fractions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fraction.fields.id') }}
                        </th>
                        <td>
                            {{ $fraction->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fraction.fields.name') }}
                        </th>
                        <td>
                            {{ $fraction->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fraction.fields.biological_set') }}
                        </th>
                        <td>
                            {{ $fraction->biological_set->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fraction.fields.spectra_file_name') }}
                        </th>
                        <td>
                            {{ $fraction->spectra_file_name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fractions.index') }}">
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
            <a class="nav-link" href="#fraction_psms" role="tab" data-toggle="tab">
                {{ trans('cruds.psm.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="fraction_psms">
            @includeIf('admin.fractions.relationships.fractionPsms', ['psms' => $fraction->fractionPsms])
        </div>
    </div>
</div>

@endsection