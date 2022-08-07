@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.project.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-primary" href="{{ route('frontend.projects.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.project.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $project->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.project.fields.name') }}
                                        </th>
                                        <td>
                                            {{ $project->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.project.fields.description') }}
                                        </th>
                                        <td>
                                            {!! $project->description !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.project.fields.public') }}
                                        </th>
                                        <td>
                                            <input type="checkbox" disabled="disabled"
                                                {{ $project->public ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.project.fields.created_by') }}
                                        </th>
                                        <td>
                                            {{ $project->created_by->name ?? '' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-primary" href="{{ route('frontend.projects.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
