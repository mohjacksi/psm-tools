@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.experiment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.experiments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.experiment.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.experiment.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $entry)
                        <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('project'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.experiment.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.experiment.fields.method') }}</label>
                <select class="form-control {{ $errors->has('method') ? 'is-invalid' : '' }}" name="method" id="method">
                    <option value disabled {{ old('method', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Experiment::METHOD_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('method', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('method'))
                    <div class="invalid-feedback">
                        {{ $errors->first('method') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.method_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('allowed_missed_cleavage') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="allowed_missed_cleavage" value="0">
                    <input class="form-check-input" type="checkbox" name="allowed_missed_cleavage" id="allowed_missed_cleavage" value="1" {{ old('allowed_missed_cleavage', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="allowed_missed_cleavage">{{ trans('cruds.experiment.fields.allowed_missed_cleavage') }}</label>
                </div>
                @if($errors->has('allowed_missed_cleavage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('allowed_missed_cleavage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.allowed_missed_cleavage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expression_threshold">{{ trans('cruds.experiment.fields.expression_threshold') }}</label>
                <input class="form-control {{ $errors->has('expression_threshold') ? 'is-invalid' : '' }}" type="number" name="expression_threshold" id="expression_threshold" value="{{ old('expression_threshold', '') }}" step="0.0001">
                @if($errors->has('expression_threshold'))
                    <div class="invalid-feedback">
                        {{ $errors->first('expression_threshold') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.expression_threshold_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="species_id">{{ trans('cruds.experiment.fields.species') }}</label>
                <select class="form-control select2 {{ $errors->has('species') ? 'is-invalid' : '' }}" name="species_id" id="species_id">
                    @foreach($species as $id => $entry)
                        <option value="{{ $id }}" {{ old('species_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('species'))
                    <div class="invalid-feedback">
                        {{ $errors->first('species') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.species_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reference_protein_source">{{ trans('cruds.experiment.fields.reference_protein_source') }}</label>
                <input class="form-control {{ $errors->has('reference_protein_source') ? 'is-invalid' : '' }}" type="text" name="reference_protein_source" id="reference_protein_source" value="{{ old('reference_protein_source', '') }}">
                @if($errors->has('reference_protein_source'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reference_protein_source') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.reference_protein_source_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other_protein_source">{{ trans('cruds.experiment.fields.other_protein_source') }}</label>
                <input class="form-control {{ $errors->has('other_protein_source') ? 'is-invalid' : '' }}" type="text" name="other_protein_source" id="other_protein_source" value="{{ old('other_protein_source', '') }}">
                @if($errors->has('other_protein_source'))
                    <div class="invalid-feedback">
                        {{ $errors->first('other_protein_source') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.other_protein_source_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="psm_file_name">{{ trans('cruds.experiment.fields.psm_file_name') }}</label>
                <input class="form-control {{ $errors->has('psm_file_name') ? 'is-invalid' : '' }}" type="text" name="psm_file_name" id="psm_file_name" value="{{ old('psm_file_name', '') }}">
                @if($errors->has('psm_file_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('psm_file_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.psm_file_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="metadata">{{ trans('cruds.experiment.fields.metadata') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('metadata') ? 'is-invalid' : '' }}" name="metadata" id="metadata">{!! old('metadata') !!}</textarea>
                @if($errors->has('metadata'))
                    <div class="invalid-feedback">
                        {{ $errors->first('metadata') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.experiment.fields.metadata_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.experiments.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $experiment->id ?? 0 }}');
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