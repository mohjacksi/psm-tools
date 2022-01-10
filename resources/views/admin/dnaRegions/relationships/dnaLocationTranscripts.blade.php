<div class="m-3">
    @can('transcript_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.transcripts.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.transcript.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.transcript.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-dnaLocationTranscripts">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.transcript.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.transcript.fields.transcript') }}
                            </th>
                            <th>
                                {{ trans('cruds.transcript.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.transcript.fields.type') }}
                            </th>
                            <th>
                                {{ trans('cruds.transcript.fields.dna_location') }}
                            </th>
                            <th>
                                {{ trans('cruds.transcript.fields.transcript_sequence') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transcripts as $key => $transcript)
                            <tr data-entry-id="{{ $transcript->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $transcript->id ?? '' }}
                                </td>
                                <td>
                                    {{ $transcript->transcript ?? '' }}
                                </td>
                                <td>
                                    {{ $transcript->name ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\Transcript::TYPE_SELECT[$transcript->type] ?? '' }}
                                </td>
                                <td>
                                    {{ $transcript->dna_location->name ?? '' }}
                                </td>
                                <td>
                                    {{ $transcript->transcript_sequence ?? '' }}
                                </td>
                                <td>
                                    @can('transcript_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.transcripts.show', $transcript->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('transcript_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.transcripts.edit', $transcript->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('transcript_delete')
                                        <form action="{{ route('admin.transcripts.destroy', $transcript->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('transcript_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.transcripts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-dnaLocationTranscripts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection