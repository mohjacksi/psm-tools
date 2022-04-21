@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.person.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.people.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.id') }}
                        </th>
                        <td>
                            {{ $person->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.name') }}
                        </th>
                        <td>
                            {{ $person->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.birth_date') }}
                        </th>
                        <td>
                            {{ $person->birth_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.sex') }}
                        </th>
                        <td>
                            {{ App\Models\Person::SEX_RADIO[$person->sex] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.project') }}
                        </th>
                        <td>
                            {{ $person->project->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.person.fields.projects') }}
                        </th>
                        <td>
                            {{ $person->projects->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.people.index') }}">
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
            <a class="nav-link" href="#person_samples" role="tab" data-toggle="tab">
                {{ trans('cruds.sample.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="person_samples">
            @includeIf('admin.people.relationships.personSamples', ['samples' => $person->personSamples])
        </div>
    </div>
</div>

@endsection