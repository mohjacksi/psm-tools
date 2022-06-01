@can('peptide_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.peptides.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.peptide.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.peptide.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-categoryPeptides">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.peptide.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.peptide.fields.sequence') }}
                        </th>
                        <th>
                            {{ trans('cruds.peptide.fields.canonical') }}
                        </th>
                        <th>
                            {{ trans('cruds.peptide.fields.canonical_frame_value') }}
                        </th>
                        <th>
                            {{ trans('cruds.peptide.fields.category') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peptides as $key => $peptide)
                        <tr data-entry-id="{{ $peptide->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $peptide->id ?? '' }}
                            </td>
                            <td>
                                {{ $peptide->sequence ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $peptide->canonical ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $peptide->canonical ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $peptide->canonical_frame_value ?? '' }}
                            </td>
                            <td>
                                {{ $peptide->category->name ?? '' }}
                            </td>
                            <td>
                                @can('peptide_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.peptides.show', $peptide->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('peptide_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.peptides.edit', $peptide->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('peptide_delete')
                                    <form action="{{ route('admin.peptides.destroy', $peptide->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('peptide_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.peptides.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-categoryPeptides:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection