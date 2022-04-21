@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sample.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.samples.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
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
                            {{ trans('cruds.sample.fields.sample_type') }}
                        </th>
                        <td>
                            {{ App\Models\Sample::SAMPLE_TYPE_SELECT[$sample->sample_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sample.fields.person') }}
                        </th>
                        <td>
                            {{ $sample->person->name ?? '' }}
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
                            {{ $sample->channel->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sample.fields.metadata') }}
                        </th>
                        <td>
                            {!! $sample->metadata !!}
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
                            {{ $sample->sample_condition }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.samples.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection