@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.strip.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.strips.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-stripd">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.strip.fields.id') }}
                            </th>
                            <td>
                                {{ $strip->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.strip.fields.name') }}
                            </th>
                            <td>
                                {{ $strip->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.strips.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#strip_biological_sets" role="tab" data-toggle="tab">
                    {{ trans('cruds.biologicalSet.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="strip_biological_sets">
                @includeIf('admin.strips.relationships.stripBiologicalSets', [
                    'biologicalSets' => $strip->stripBiologicalSets,
                ])
            </div>
        </div>
    </div>
@endsection
