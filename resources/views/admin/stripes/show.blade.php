@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.stripe.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stripes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.stripe.fields.id') }}
                        </th>
                        <td>
                            {{ $stripe->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.stripe.fields.name') }}
                        </th>
                        <td>
                            {{ $stripe->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stripes.index') }}">
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
            <a class="nav-link" href="#stripe_biological_sets" role="tab" data-toggle="tab">
                {{ trans('cruds.biologicalSet.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="stripe_biological_sets">
            @includeIf('admin.stripes.relationships.stripeBiologicalSets', ['biologicalSets' => $stripe->stripeBiologicalSets])
        </div>
    </div>
</div>

@endsection