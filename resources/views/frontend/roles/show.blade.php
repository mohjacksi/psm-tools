@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.role.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.role.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $role->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.role.fields.title') }}
                                        </th>
                                        <td>
                                            {{ $role->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.role.fields.permissions') }}
                                        </th>
                                        <td>
                                            @foreach ($role->permissions as $key => $permissions)
                                                <span class="label label-info">{{ $permissions->title }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
