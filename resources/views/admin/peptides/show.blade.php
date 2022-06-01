@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.peptide.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptides.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.peptide.fields.id') }}
                        </th>
                        <td>
                            {{ $peptide->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptide.fields.sequence') }}
                        </th>
                        <td>
                            {{ $peptide->sequence }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptide.fields.canonical') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $peptide->canonical ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptide.fields.canonical_frame_value') }}
                        </th>
                        <td>
                            {{ $peptide->canonical_frame_value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptide.fields.category') }}
                        </th>
                        <td>
                            {{ $peptide->category->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptides.index') }}">
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
            <a class="nav-link" href="#peptide_proteins" role="tab" data-toggle="tab">
                {{ trans('cruds.protein.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="peptide_proteins">
            @includeIf('admin.peptides.relationships.peptideProteins', ['proteins' => $peptide->peptideProteins])
        </div>
    </div>
</div>

@endsection