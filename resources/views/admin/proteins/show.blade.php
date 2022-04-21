@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.protein.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.proteins.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.id') }}
                        </th>
                        <td>
                            {{ $protein->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.protein') }}
                        </th>
                        <td>
                            {{ $protein->protein }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.sequence') }}
                        </th>
                        <td>
                            {!! $protein->sequence !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.name') }}
                        </th>
                        <td>
                            {{ $protein->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Protein::TYPE_SELECT[$protein->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.source') }}
                        </th>
                        <td>
                            {!! $protein->source !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.metadata') }}
                        </th>
                        <td>
                            {!! $protein->metadata !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.proteins.index') }}">
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
            <a class="nav-link" href="#protein_peptide_proteins" role="tab" data-toggle="tab">
                {{ trans('cruds.peptideProtein.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="protein_peptide_proteins">
            @includeIf('admin.proteins.relationships.proteinPeptideProteins', ['peptideProteins' => $protein->proteinPeptideProteins])
        </div>
    </div>
</div>

@endsection