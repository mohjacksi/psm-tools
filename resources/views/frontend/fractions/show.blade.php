@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.fraction.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fraction.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $fraction->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fraction.fields.name') }}
                                        </th>
                                        <td>
                                            {{ $fraction->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fraction.fields.biological_set') }}
                                        </th>
                                        <td>
                                            {{ $fraction->biological_set->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fraction.fields.spectra_file_name') }}
                                        </th>
                                        <td>
                                            {{ $fraction->spectra_file_name }}
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
