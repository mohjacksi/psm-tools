@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.protein.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.proteins.saveUploadTsv") }}" enctype="multipart/form-data" id="proteinForm">
            @csrf
            <div class="form-group">
                <label class="required" for="protein_file">{{ trans('cruds.protein.fields.protein_file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('protein_file') ? 'is-invalid' : '' }}" id="psm_file-dropzone">
                </div>
                @if($errors->has('protein_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('protein_file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.protein.fields.protein_file') }}</span>
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
    Dropzone.options.psmFileDropzone = {
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
      $('#proteinForm').find('input[name="protein_file"]').remove()
      $('#proteinForm').append('<input type="hidden" name="protein_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('#proteinForm').find('input[name="protein_file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($uploadForm) && $uploadForm->psm_file)
      var file = {!! json_encode($uploadForm->psm_file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('#proteinForm').append('<input type="hidden" name="protein_file" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
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