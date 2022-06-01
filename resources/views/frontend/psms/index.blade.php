@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('psm_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.psms.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.psm.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'Psm', 'route' => 'admin.psms.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.psm.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Psm">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.psm.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.spectra') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.fraction') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.scan_num') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.precursor') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.isotope_error') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.precursor_error') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.charge') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.de_novo_score') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.msgf_score') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.space_evalue') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.evalue') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.precursor_svm_score') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.psm_q_value') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.peptide_q_value') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.missed_clevage') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.experimental_pl') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.predicted_pl') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.delta_pl') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.psm.fields.peptide_with_modification') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($fractions as $key => $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($peptide_with_modifications as $key => $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($psms as $key => $psm)
                                    <tr data-entry-id="{{ $psm->id }}">
                                        <td>
                                            {{ $psm->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->spectra ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->fraction->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->scan_num ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->precursor ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->isotope_error ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->precursor_error ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->charge ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->de_novo_score ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->msgf_score ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->space_evalue ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->evalue ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->precursor_svm_score ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->psm_q_value ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->peptide_q_value ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->missed_clevage ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->experimental_pl ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->predicted_pl ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->delta_pl ?? '' }}
                                        </td>
                                        <td>
                                            {{ $psm->peptide_with_modification->name ?? '' }}
                                        </td>
                                        <td>
                                            @can('psm_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.psms.show', $psm->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('psm_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.psms.edit', $psm->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('psm_delete')
                                                <form action="{{ route('frontend.psms.destroy', $psm->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('psm_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.psms.massDestroy') }}",
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
  let table = $('.datatable-Psm:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
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