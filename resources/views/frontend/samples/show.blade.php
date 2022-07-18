@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.sample.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.samples.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $sample->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.name') }}
                                        </th>
                                        <td>
                                            {{ $sample->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.details') }}
                                        </th>
                                        <td>
                                            {!! $sample->details !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.replicate_number') }}
                                        </th>
                                        <td>
                                            {{ $sample->replicate_number }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.project') }}
                                        </th>
                                        <td>
                                            {{ $sample->project->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.channel') }}
                                        </th>
                                        <td>
                                            @foreach ($sample->channels as $key => $channel)
                                                <span class="label label-info">{{ $channel->name }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.species') }}
                                        </th>
                                        <td>
                                            {{ $sample->species->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.tissue') }}
                                        </th>
                                        <td>
                                            {{ $sample->tissue->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.sample_condition') }}
                                        </th>
                                        <td>
                                            {{ $sample->sample_condition->name ?? '' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.samples.index') }}">
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
