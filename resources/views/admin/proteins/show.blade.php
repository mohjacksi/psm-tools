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
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.peptide') }}
                        </th>
                        <td>
                            {{ $protein->peptide->sequence ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.protein.fields.type') }}
                        </th>
                        <td>
                            {{ $protein->type->name ?? '' }}
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



@endsection