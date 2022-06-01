@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.uploadForm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.upload-forms.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="project_id">{{ trans('cruds.uploadForm.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id" required>
                    @foreach($projects as $id => $entry)
                        <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('project'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.uploadForm.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="experiment_id">{{ trans('cruds.uploadForm.fields.experiment') }}</label>
                <select class="form-control select2 {{ $errors->has('experiment') ? 'is-invalid' : '' }}" name="experiment_id" id="experiment_id" required>
                    @foreach($experiments as $id => $entry)
                        <option value="{{ $id }}" {{ old('experiment_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('experiment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experiment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.uploadForm.fields.experiment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="psm_file">{{ trans('cruds.uploadForm.fields.psm_file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('psm_file') ? 'is-invalid' : '' }}" id="psm_file-dropzone">
                </div>
                @if($errors->has('psm_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('psm_file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.uploadForm.fields.psm_file_helper') }}</span>
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
      $('form').find('input[name="psm_file"]').remove()
      $('form').append('<input type="hidden" name="psm_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="psm_file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($uploadForm) && $uploadForm->psm_file)
      var file = {!! json_encode($uploadForm->psm_file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="psm_file" value="' + file.file_name + '">')
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