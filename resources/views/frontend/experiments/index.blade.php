@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('experiment_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.experiments.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.experiment.title_singular') }}
                            </a>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                                {{ trans('global.app_csvImport') }}
                            </button>
                            @include('csvImport.modal', [
                                'model' => 'Experiment',
                                'route' => 'admin.experiments.parseCsvImport',
                            ])
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.experiment.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-stripd table-hover datatable datatable-Experiment">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.experiment.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.name') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.project') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.date') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.method') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.allowed_missed_cleavage') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.expression_threshold') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.species') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.reference_protein_source') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.other_protein_source') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.experiment.fields.psm_file_name') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($projects as $key => $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <select class="search" strict="true">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach (App\Models\Experiment::METHOD_SELECT as $key => $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($speciess as $key => $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($experiments as $key => $experiment)
                                        <tr data-entry-id="{{ $experiment->id }}">
                                            <td>
                                                {{ $experiment->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $experiment->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $experiment->project->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $experiment->date ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Experiment::METHOD_SELECT[$experiment->method] ?? '' }}
                                            </td>
                                            <td>
                                                <span
                                                    style="display:none">{{ $experiment->allowed_missed_cleavage ?? '' }}</span>
                                                <input type="checkbox" disabled="disabled"
                                                    {{ $experiment->allowed_missed_cleavage ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                {{ $experiment->expression_threshold ?? '' }}
                                            </td>
                                            <td>
                                                {{ $experiment->species->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $experiment->reference_protein_source ?? '' }}
                                            </td>
                                            <td>
                                                {{ $experiment->other_protein_source ?? '' }}
                                            </td>
                                            <td>
                                                {{ $experiment->psm_file_name ?? '' }}
                                            </td>
                                            <td>
                                                @can('experiment_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.experiments.show', $experiment->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('experiment_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.experiments.edit', $experiment->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('experiment_delete')
                                                    <form
                                                        action="{{ route('frontend.experiments.destroy', $experiment->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                        style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger"
                                                            value="{{ trans('global.delete') }}">
                                                    </form>
                                                @endcan

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('experiment_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.experiments.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Experiment:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        })
    </script>
@endsection
