@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.transcript.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.transcript.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $transcript->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.transcript.fields.transcript') }}
                                        </th>
                                        <td>
                                            {{ $transcript->transcript }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.transcript.fields.name') }}
                                        </th>
                                        <td>
                                            {{ $transcript->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.transcript.fields.type') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Transcript::TYPE_SELECT[$transcript->type] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.transcript.fields.transcript_sequence') }}
                                        </th>
                                        <td>
                                            {{ $transcript->transcript_sequence }}
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
