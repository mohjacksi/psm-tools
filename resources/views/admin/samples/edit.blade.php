@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.sample.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.samples.update", [$sample->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.sample.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $sample->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="details">{{ trans('cruds.sample.fields.details') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('details') ? 'is-invalid' : '' }}" name="details" id="details">{!! old('details', $sample->details) !!}</textarea>
                @if($errors->has('details'))
                    <div class="invalid-feedback">
                        {{ $errors->first('details') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.details_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="replicate_number">{{ trans('cruds.sample.fields.replicate_number') }}</label>
                <input class="form-control {{ $errors->has('replicate_number') ? 'is-invalid' : '' }}" type="number" name="replicate_number" id="replicate_number" value="{{ old('replicate_number', $sample->replicate_number) }}" step="1">
                @if($errors->has('replicate_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('replicate_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.replicate_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.sample.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id">
                    @foreach($projects as $id => $entry)
                        <option value="{{ $id }}" {{ (old('project_id') ? old('project_id') : $sample->project->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <label for="channels">{{ trans('cruds.sample.fields.channel') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('channels') ? 'is-invalid' : '' }}" name="channels[]" id="channels" multiple>
                    @foreach($channels as $id => $channel)
                        <option value="{{ $id }}" {{ (in_array($id, old('channels', [])) || $sample->channels->contains($id)) ? 'selected' : '' }}>{{ $channel }}</option>
                    @endforeach
                </select>
                @if($errors->has('channels'))
                    <div class="invalid-feedback">
                        {{ $errors->first('channels') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.channel_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="species_id">{{ trans('cruds.sample.fields.species') }}</label>
                <select class="form-control select2 {{ $errors->has('species') ? 'is-invalid' : '' }}" name="species_id" id="species_id">
                    @foreach($species as $id => $entry)
                        <option value="{{ $id }}" {{ (old('species_id') ? old('species_id') : $sample->species->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('species'))
                    <div class="invalid-feedback">
                        {{ $errors->first('species') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sample.fields.species_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tissue_id">{{ trans('cruds.sample.fields.tissue') }}</label>
                <select class="form-control select2 {{ $errors->has('tissue') ? 'is-invalid' : '' }}" name="tissue_id" id="tissue_id">
                    @foreach($tissues as $id => $entry)
                        <option value="{{ $id }}" {{ (old('tissue_id') ? old('tissue_id') : $sample->tissue->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <label for="sample_condition_id">{{ trans('cruds.sample.fields.sample_condition') }}</label>
                <select class="form-control select2 {{ $errors->has('sample_condition') ? 'is-invalid' : '' }}" name="sample_condition_id" id="sample_condition_id">
                    @foreach($sample_conditions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('sample_condition_id') ? old('sample_condition_id') : $sample->sample_condition->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
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