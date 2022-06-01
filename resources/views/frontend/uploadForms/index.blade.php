@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('upload_form_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.upload-forms.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.uploadForm.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.uploadForm.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-UploadForm">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.uploadForm.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.uploadForm.fields.project') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.uploadForm.fields.experiment') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.uploadForm.fields.psm_file') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($uploadForms as $key => $uploadForm)
                                    <tr data-entry-id="{{ $uploadForm->id }}">
                                        <td>
                                            {{ $uploadForm->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $uploadForm->project->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $uploadForm->experiment->name ?? '' }}
                                        </td>
                                        <td>
                                            @if($uploadForm->psm_file)
                                                <a href="{{ $uploadForm->psm_file->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @can('upload_form_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.upload-forms.show', $uploadForm->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('upload_form_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.upload-forms.edit', $uploadForm->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('upload_form_delete')
                                                <form action="{{ route('frontend.upload-forms.destroy', $uploadForm->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('upload_form_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.upload-forms.massDestroy') }}",
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
  let table = $('.datatable-UploadForm:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection