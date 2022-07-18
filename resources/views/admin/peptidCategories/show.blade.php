@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.peptidCategory.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.peptid-categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-stripd">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.peptidCategory.fields.id') }}
                            </th>
                            <td>
                                {{ $peptidCategory->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.peptidCategory.fields.name') }}
                            </th>
                            <td>
                                {{ $peptidCategory->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.peptid-categories.index') }}">
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
                <a class="nav-link" href="#category_peptides" role="tab" data-toggle="tab">
                    {{ trans('cruds.peptide.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="category_peptides">
                @includeIf('admin.peptidCategories.relationships.categoryPeptides', [
                    'peptides' => $peptidCategory->categoryPeptides,
                ])
            </div>
        </div>
    </div>
@endsection
