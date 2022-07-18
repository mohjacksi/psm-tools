@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('sample_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.samples.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.sample.title_singular') }}
                            </a>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                                {{ trans('global.app_csvImport') }}
                            </button>
                            @include('csvImport.modal', [
                                'model' => 'Sample',
                                'route' => 'admin.samples.parseCsvImport',
                            ])
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.sample.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-stripd table-hover datatable datatable-Sample">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sample.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sample.fields.name') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sample.fields.replicate_number') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sample.fields.project') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sample.fields.channel') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sample.fields.species') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sample.fields.tissue') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sample.fields.sample_condition') }}
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
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($channels as $key => $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
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
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($tissues as $key => $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($sample_conditions as $key => $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($samples as $key => $sample)
                                        <tr data-entry-id="{{ $sample->id }}">
                                            <td>
                                                {{ $sample->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sample->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sample->replicate_number ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sample->project->name ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($sample->channels as $key => $item)
                                                    <span>{{ $item->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $sample->species->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sample->tissue->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sample->sample_condition->name ?? '' }}
                                            </td>
                                            <td>
                                                @can('sample_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.samples.show', $sample->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('sample_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.samples.edit', $sample->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('sample_delete')
                                                    <form action="{{ route('frontend.samples.destroy', $sample->id) }}"
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
            @can('sample_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.samples.massDestroy') }}",
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
            let table = $('.datatable-Sample:not(.ajaxTable)').DataTable({
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
