@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.tissue.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.tissue.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $tissue->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.tissue.fields.name') }}
                                        </th>
                                        <td>
                                            {{ $tissue->name }}
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
