@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('peptide_with_modification_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.peptide-with-modifications.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.peptideWithModification.title_singular') }}
                            </a>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                                {{ trans('global.app_csvImport') }}
                            </button>
                            @include('csvImport.modal', [
                                'model' => 'PeptideWithModification',
                                'route' => 'admin.peptide-with-modifications.parseCsvImport',
                            ])
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.peptideWithModification.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class=" table table-bordered table-stripd table-hover datatable datatable-PeptideWithModification">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.peptideWithModification.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.peptideWithModification.fields.name') }}
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
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peptideWithModifications as $key => $peptideWithModification)
                                        <tr data-entry-id="{{ $peptideWithModification->id }}">
                                            <td>
                                                {{ $peptideWithModification->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $peptideWithModification->name ?? '' }}
                                            </td>
                                            <td>
                                                @can('peptide_with_modification_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.peptide-with-modifications.show', $peptideWithModification->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('peptide_with_modification_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.peptide-with-modifications.edit', $peptideWithModification->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('peptide_with_modification_delete')
                                                    <form
                                                        action="{{ route('frontend.peptide-with-modifications.destroy', $peptideWithModification->id) }}"
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
            @can('peptide_with_modification_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.peptide-with-modifications.massDestroy') }}",
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
            let table = $('.datatable-PeptideWithModification:not(.ajaxTable)').DataTable({
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
