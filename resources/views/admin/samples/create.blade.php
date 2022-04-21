@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sample.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.samples.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.sample.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="details">{{ trans('cruds.sample.fields.details') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('details') ? 'is-invalid' : '' }}" name="details" id="details">{!! old('details') !!}</textarea>
                @if($errors->has('details'))
                    <div class="invalid-feedback">
                        {{ $errors->first('details') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.details_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.sample.fields.sample_type') }}</label>
                <select class="form-control {{ $errors->has('sample_type') ? 'is-invalid' : '' }}" name="sample_type" id="sample_type">
                    <option value disabled {{ old('sample_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Sample::SAMPLE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('sample_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('sample_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sample_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.sample_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_id">{{ trans('cruds.sample.fields.person') }}</label>
                <select class="form-control select2 {{ $errors->has('person') ? 'is-invalid' : '' }}" name="person_id" id="person_id">
                    @foreach($people as $id => $entry)
                        <option value="{{ $id }}" {{ old('person_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('person'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.person_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.sample.fields.project') }}</label>
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
                <span class="help-block">{{ trans('cruds.sample.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="channel_id">{{ trans('cruds.sample.fields.channel') }}</label>
                <select class="form-control select2 {{ $errors->has('channel') ? 'is-invalid' : '' }}" name="channel_id" id="channel_id">
                    @foreach($channels as $id => $entry)
                        <option value="{{ $id }}" {{ old('channel_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('channel'))
                    <div class="invalid-feedback">
                        {{ $errors->first('channel') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.channel_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="metadata">{{ trans('cruds.sample.fields.metadata') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('metadata') ? 'is-invalid' : '' }}" name="metadata" id="metadata">{!! old('metadata') !!}</textarea>
                @if($errors->has('metadata'))
                    <div class="invalid-feedback">
                        {{ $errors->first('metadata') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.metadata_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tissue_id">{{ trans('cruds.sample.fields.tissue') }}</label>
                <select class="form-control select2 {{ $errors->has('tissue') ? 'is-invalid' : '' }}" name="tissue_id" id="tissue_id">
                    @foreach($tissues as $id => $entry)
                        <option value="{{ $id }}" {{ old('tissue_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tissue'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tissue') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.tissue_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sample_condition">{{ trans('cruds.sample.fields.sample_condition') }}</label>
                <input class="form-control {{ $errors->has('sample_condition') ? 'is-invalid' : '' }}" type="text" name="sample_condition" id="sample_condition" value="{{ old('sample_condition', '') }}">
                @if($errors->has('sample_condition'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sample_condition') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.sample_condition_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.samples.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $sample->id ?? 0 }}');
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