@can('sample_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.samples.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sample.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.sample.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-stripd table-hover datatable datatable-speciesSamples">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
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
                </thead>
                <tbody>
                    @foreach ($samples as $key => $sample)
                        <tr data-entry-id="{{ $sample->id }}">
                            <td>

                            </td>
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
                                    <span class="badge badge-info">{{ $item->name }}</span>
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
                                        href="{{ route('admin.samples.show', $sample->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sample_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.samples.edit', $sample->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sample_delete')
                                    <form action="{{ route('admin.samples.destroy', $sample->id) }}" method="POST"
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

@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('sample_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.samples.massDestroy') }}",
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
            let table = $('.datatable-speciesSamples:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
