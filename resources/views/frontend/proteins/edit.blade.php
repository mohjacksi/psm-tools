@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.protein.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.proteins.update", [$protein->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="sequence">{{ trans('cruds.protein.fields.sequence') }}</label>
                            <textarea class="form-control ckeditor" name="sequence" id="sequence">{!! old('sequence', $protein->sequence) !!}</textarea>
                            @if($errors->has('sequence'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sequence') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.protein.fields.sequence_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.protein.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $protein->name) }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.protein.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="source">{{ trans('cruds.protein.fields.source') }}</label>
                            <textarea class="form-control ckeditor" name="source" id="source">{!! old('source', $protein->source) !!}</textarea>
                            @if($errors->has('source'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('source') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.protein.fields.source_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="metadata">{{ trans('cruds.protein.fields.metadata') }}</label>
                            <textarea class="form-control ckeditor" name="metadata" id="metadata">{!! old('metadata', $protein->metadata) !!}</textarea>
                            @if($errors->has('metadata'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('metadata') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.protein.fields.metadata_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="peptide_id">{{ trans('cruds.protein.fields.peptide') }}</label>
                            <select class="form-control select2" name="peptide_id" id="peptide_id" required>
                                @foreach($peptides as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('peptide_id') ? old('peptide_id') : $protein->peptide->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('peptide'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('peptide') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.protein.fields.peptide_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="type_id">{{ trans('cruds.protein.fields.type') }}</label>
                            <select class="form-control select2" name="type_id" id="type_id">
                                @foreach($types as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('type_id') ? old('type_id') : $protein->type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.protein.fields.type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('frontend.proteins.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $protein->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection