@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tissue.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tissues.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
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
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tissues.index') }}">
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
            <a class="nav-link" href="#tissue_samples" role="tab" data-toggle="tab">
                {{ trans('cruds.sample.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="tissue_samples">
            @includeIf('admin.tissues.relationships.tissueSamples', ['samples' => $tissue->tissueSamples])
        </div>
    </div>
</div>

@endsection