@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('protein_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.proteins.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.protein.title_singular') }}
                            </a>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                                {{ trans('global.app_csvImport') }}
                            </button>
                            @include('csvImport.modal', [
                                'model' => 'Protein',
                                'route' => 'admin.proteins.parseCsvImport',
                            ])
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.protein.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-stripd table-hover datatable datatable-Protein">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.protein.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.protein.fields.name') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.protein.fields.peptide') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.protein.fields.type') }}
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
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($peptides as $key => $item)
                                                    <option value="{{ $item->sequence }}">{{ $item->sequence }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($protein_types as $key => $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proteins as $key => $protein)
                                        <tr data-entry-id="{{ $protein->id }}">
                                            <td>
                                                {{ $protein->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $protein->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $protein->peptide->sequence ?? '' }}
                                            </td>
                                            <td>
                                                {{ $protein->type->name ?? '' }}
                                            </td>
                                            <td>
                                                @can('protein_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.proteins.show', $protein->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('protein_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.proteins.edit', $protein->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('protein_delete')
                                                    <form action="{{ route('frontend.proteins.destroy', $protein->id) }}"
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
            @can('protein_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.proteins.massDestroy') }}",
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
            let table = $('.datatable-Protein:not(.ajaxTable)').DataTable({
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
