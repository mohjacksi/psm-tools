@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.peptide.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.peptides.saveUploadTsv") }}" enctype="multipart/form-data" id="peptideForm">
            @csrf
            <div class="form-group">
                <label class="required" for="peptide_file">{{ trans('cruds.peptide.fields.peptide_file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('peptide_file') ? 'is-invalid' : '' }}" id="peptide_file-dropzone">
                </div>
                @if($errors->has('peptide_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('peptide_file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.peptide.fields.peptide_file') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    Dropzone.options.peptideFileDropzone = {
    url: '{{ route('admin.upload-forms.storeMedia') }}',
    maxFilesize: 1024, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 1024
    },
    success: function (file, response) {
        console.log(response);
      $('#peptideForm').find('input[name="peptide_file"]').remove()
      $('#peptideForm').append('<input type="hidden" name="peptide_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('#peptideForm').find('input[name="peptide_file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection