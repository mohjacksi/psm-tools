@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.dnaRegion.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.dna-regions.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-stripd">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.dnaRegion.fields.id') }}
                            </th>
                            <td>
                                {{ $dnaRegion->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.dnaRegion.fields.name') }}
                            </th>
                            <td>
                                {{ $dnaRegion->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.dna-regions.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
