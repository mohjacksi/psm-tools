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
                            {{ trans('cruds.peptide.fields.genomic_location') }}
                        </th>
                        <td>
                            {{ $peptide->genomic_location }}
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
            <a class="nav-link" href="#peptide_peptide_psms" role="tab" data-toggle="tab">
                {{ trans('cruds.peptidePsm.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#peptide_peptide_proteins" role="tab" data-toggle="tab">
                {{ trans('cruds.peptideProtein.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="peptide_peptide_psms">
            @includeIf('admin.peptides.relationships.peptidePeptidePsms', ['peptidePsms' => $peptide->peptidePeptidePsms])
        </div>
        <div class="tab-pane" role="tabpanel" id="peptide_peptide_proteins">
            @includeIf('admin.peptides.relationships.peptidePeptideProteins', ['peptideProteins' => $peptide->peptidePeptideProteins])
        </div>
    </div>
</div>

@endsection