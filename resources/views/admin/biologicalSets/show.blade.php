@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.biologicalSet.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.biological-sets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.biologicalSet.fields.id') }}
                        </th>
                        <td>
                            {{ $biologicalSet->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.biologicalSet.fields.name') }}
                        </th>
                        <td>
                            {{ $biologicalSet->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.biologicalSet.fields.experiment_biological_set') }}
                        </th>
                        <td>
                            {{ $biologicalSet->experiment_biological_set->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.biologicalSet.fields.stripe') }}
                        </th>
                        <td>
                            {{ $biologicalSet->stripe->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.biologicalSet.fields.fragment_method') }}
                        </th>
                        <td>
                            {{ $biologicalSet->fragment_method->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.biological-sets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection