@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.peptide.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.peptide.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $peptide->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.peptide.fields.sequence') }}
                                        </th>
                                        <td>
                                            {{ $peptide->sequence }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.peptide.fields.canonical') }}
                                        </th>
                                        <td>
                                            <input type="checkbox" disabled="disabled"
                                                {{ $peptide->canonical ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.peptide.fields.canonical_frame_value') }}
                                        </th>
                                        <td>
                                            {{ $peptide->canonical_frame_value }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.peptide.fields.category') }}
                                        </th>
                                        <td>
                                            {{ $peptide->category->name ?? '' }}
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
