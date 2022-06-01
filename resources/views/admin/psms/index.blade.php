@extends('layouts.admin')
@section('content')
@can('psm_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.psms.create') }}">
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Psm">
            <thead>
                <tr>
                    <th width="10">

                    </th>
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('psm_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.psms.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.psms.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'spectra', name: 'spectra' },
{ data: 'fraction_name', name: 'fraction.name' },
{ data: 'scan_num', name: 'scan_num' },
{ data: 'precursor', name: 'precursor' },
{ data: 'isotope_error', name: 'isotope_error' },
{ data: 'precursor_error', name: 'precursor_error' },
{ data: 'charge', name: 'charge' },
{ data: 'de_novo_score', name: 'de_novo_score' },
{ data: 'msgf_score', name: 'msgf_score' },
{ data: 'space_evalue', name: 'space_evalue' },
{ data: 'evalue', name: 'evalue' },
{ data: 'precursor_svm_score', name: 'precursor_svm_score' },
{ data: 'psm_q_value', name: 'psm_q_value' },
{ data: 'peptide_q_value', name: 'peptide_q_value' },
{ data: 'missed_clevage', name: 'missed_clevage' },
{ data: 'experimental_pl', name: 'experimental_pl' },
{ data: 'predicted_pl', name: 'predicted_pl' },
{ data: 'delta_pl', name: 'delta_pl' },
{ data: 'peptide_with_modification_name', name: 'peptide_with_modification.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Psm').DataTable(dtOverrideGlobals);
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
});

</script>
@endsection