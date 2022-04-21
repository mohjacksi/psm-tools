@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.peptideProtein.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptide-proteins.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.peptideProtein.fields.id') }}
                        </th>
                        <td>
                            {{ $peptideProtein->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptideProtein.fields.name') }}
                        </th>
                        <td>
                            {{ $peptideProtein->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptideProtein.fields.peptide') }}
                        </th>
                        <td>
                            {{ $peptideProtein->peptide->sequence ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.peptideProtein.fields.protein') }}
                        </th>
                        <td>
                            {{ $peptideProtein->protein->protein ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.peptide-proteins.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection