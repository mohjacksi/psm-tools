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
                            {{ trans('cruds.protein.fields.protein_sequence') }}
                        </th>
                        <td>
                            {{ $protein->protein_sequence }}
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