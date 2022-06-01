@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.proteinType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.protein-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.proteinType.fields.id') }}
                        </th>
                        <td>
                            {{ $proteinType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.proteinType.fields.name') }}
                        </th>
                        <td>
                            {{ $proteinType->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.protein-types.index') }}">
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
            <a class="nav-link" href="#type_proteins" role="tab" data-toggle="tab">
                {{ trans('cruds.protein.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="type_proteins">
            @includeIf('admin.proteinTypes.relationships.typeProteins', ['proteins' => $proteinType->typeProteins])
        </div>
    </div>
</div>

@endsection