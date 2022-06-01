@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.psm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.psms.update", [$psm->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="spectra">{{ trans('cruds.psm.fields.spectra') }}</label>
                <input class="form-control {{ $errors->has('spectra') ? 'is-invalid' : '' }}" type="text" name="spectra" id="spectra" value="{{ old('spectra', $psm->spectra) }}" required>
                @if($errors->has('spectra'))
                    <div class="invalid-feedback">
                        {{ $errors->first('spectra') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.spectra_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="fraction_id">{{ trans('cruds.psm.fields.fraction') }}</label>
                <select class="form-control select2 {{ $errors->has('fraction') ? 'is-invalid' : '' }}" name="fraction_id" id="fraction_id" required>
                    @foreach($fractions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('fraction_id') ? old('fraction_id') : $psm->fraction->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('fraction'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fraction') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.fraction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="peptide_modification">{{ trans('cruds.psm.fields.peptide_modification') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('peptide_modification') ? 'is-invalid' : '' }}" name="peptide_modification" id="peptide_modification">{!! old('peptide_modification', $psm->peptide_modification) !!}</textarea>
                @if($errors->has('peptide_modification'))
                    <div class="invalid-feedback">
                        {{ $errors->first('peptide_modification') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.peptide_modification_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="scan_num">{{ trans('cruds.psm.fields.scan_num') }}</label>
                <input class="form-control {{ $errors->has('scan_num') ? 'is-invalid' : '' }}" type="number" name="scan_num" id="scan_num" value="{{ old('scan_num', $psm->scan_num) }}" step="1">
                @if($errors->has('scan_num'))
                    <div class="invalid-feedback">
                        {{ $errors->first('scan_num') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.scan_num_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="precursor">{{ trans('cruds.psm.fields.precursor') }}</label>
                <input class="form-control {{ $errors->has('precursor') ? 'is-invalid' : '' }}" type="number" name="precursor" id="precursor" value="{{ old('precursor', $psm->precursor) }}" step="0.00001">
                @if($errors->has('precursor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('precursor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.precursor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="isotope_error">{{ trans('cruds.psm.fields.isotope_error') }}</label>
                <input class="form-control {{ $errors->has('isotope_error') ? 'is-invalid' : '' }}" type="number" name="isotope_error" id="isotope_error" value="{{ old('isotope_error', $psm->isotope_error) }}" step="1">
                @if($errors->has('isotope_error'))
                    <div class="invalid-feedback">
                        {{ $errors->first('isotope_error') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.isotope_error_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="precursor_error">{{ trans('cruds.psm.fields.precursor_error') }}</label>
                <input class="form-control {{ $errors->has('precursor_error') ? 'is-invalid' : '' }}" type="number" name="precursor_error" id="precursor_error" value="{{ old('precursor_error', $psm->precursor_error) }}" step="0.00001">
                @if($errors->has('precursor_error'))
                    <div class="invalid-feedback">
                        {{ $errors->first('precursor_error') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.precursor_error_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="charge">{{ trans('cruds.psm.fields.charge') }}</label>
                <input class="form-control {{ $errors->has('charge') ? 'is-invalid' : '' }}" type="number" name="charge" id="charge" value="{{ old('charge', $psm->charge) }}" step="1">
                @if($errors->has('charge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('charge') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.charge_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="de_novo_score">{{ trans('cruds.psm.fields.de_novo_score') }}</label>
                <input class="form-control {{ $errors->has('de_novo_score') ? 'is-invalid' : '' }}" type="text" name="de_novo_score" id="de_novo_score" value="{{ old('de_novo_score', $psm->de_novo_score) }}">
                @if($errors->has('de_novo_score'))
                    <div class="invalid-feedback">
                        {{ $errors->first('de_novo_score') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.de_novo_score_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="msgf_score">{{ trans('cruds.psm.fields.msgf_score') }}</label>
                <input class="form-control {{ $errors->has('msgf_score') ? 'is-invalid' : '' }}" type="number" name="msgf_score" id="msgf_score" value="{{ old('msgf_score', $psm->msgf_score) }}" step="1">
                @if($errors->has('msgf_score'))
                    <div class="invalid-feedback">
                        {{ $errors->first('msgf_score') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.msgf_score_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="space_evalue">{{ trans('cruds.psm.fields.space_evalue') }}</label>
                <input class="form-control {{ $errors->has('space_evalue') ? 'is-invalid' : '' }}" type="number" name="space_evalue" id="space_evalue" value="{{ old('space_evalue', $psm->space_evalue) }}" step="1">
                @if($errors->has('space_evalue'))
                    <div class="invalid-feedback">
                        {{ $errors->first('space_evalue') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.space_evalue_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="evalue">{{ trans('cruds.psm.fields.evalue') }}</label>
                <input class="form-control {{ $errors->has('evalue') ? 'is-invalid' : '' }}" type="text" name="evalue" id="evalue" value="{{ old('evalue', $psm->evalue) }}">
                @if($errors->has('evalue'))
                    <div class="invalid-feedback">
                        {{ $errors->first('evalue') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.evalue_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="precursor_svm_score">{{ trans('cruds.psm.fields.precursor_svm_score') }}</label>
                <input class="form-control {{ $errors->has('precursor_svm_score') ? 'is-invalid' : '' }}" type="text" name="precursor_svm_score" id="precursor_svm_score" value="{{ old('precursor_svm_score', $psm->precursor_svm_score) }}">
                @if($errors->has('precursor_svm_score'))
                    <div class="invalid-feedback">
                        {{ $errors->first('precursor_svm_score') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.precursor_svm_score_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="psm_q_value">{{ trans('cruds.psm.fields.psm_q_value') }}</label>
                <input class="form-control {{ $errors->has('psm_q_value') ? 'is-invalid' : '' }}" type="number" name="psm_q_value" id="psm_q_value" value="{{ old('psm_q_value', $psm->psm_q_value) }}" step="0.00001">
                @if($errors->has('psm_q_value'))
                    <div class="invalid-feedback">
                        {{ $errors->first('psm_q_value') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.psm_q_value_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="peptide_q_value">{{ trans('cruds.psm.fields.peptide_q_value') }}</label>
                <input class="form-control {{ $errors->has('peptide_q_value') ? 'is-invalid' : '' }}" type="number" name="peptide_q_value" id="peptide_q_value" value="{{ old('peptide_q_value', $psm->peptide_q_value) }}" step="0.00001">
                @if($errors->has('peptide_q_value'))
                    <div class="invalid-feedback">
                        {{ $errors->first('peptide_q_value') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.peptide_q_value_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="missed_clevage">{{ trans('cruds.psm.fields.missed_clevage') }}</label>
                <input class="form-control {{ $errors->has('missed_clevage') ? 'is-invalid' : '' }}" type="number" name="missed_clevage" id="missed_clevage" value="{{ old('missed_clevage', $psm->missed_clevage) }}" step="1">
                @if($errors->has('missed_clevage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('missed_clevage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.missed_clevage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experimental_pl">{{ trans('cruds.psm.fields.experimental_pl') }}</label>
                <input class="form-control {{ $errors->has('experimental_pl') ? 'is-invalid' : '' }}" type="number" name="experimental_pl" id="experimental_pl" value="{{ old('experimental_pl', $psm->experimental_pl) }}" step="0.00001">
                @if($errors->has('experimental_pl'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experimental_pl') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.experimental_pl_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="predicted_pl">{{ trans('cruds.psm.fields.predicted_pl') }}</label>
                <input class="form-control {{ $errors->has('predicted_pl') ? 'is-invalid' : '' }}" type="number" name="predicted_pl" id="predicted_pl" value="{{ old('predicted_pl', $psm->predicted_pl) }}" step="0.00001">
                @if($errors->has('predicted_pl'))
                    <div class="invalid-feedback">
                        {{ $errors->first('predicted_pl') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.predicted_pl_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="delta_pl">{{ trans('cruds.psm.fields.delta_pl') }}</label>
                <input class="form-control {{ $errors->has('delta_pl') ? 'is-invalid' : '' }}" type="number" name="delta_pl" id="delta_pl" value="{{ old('delta_pl', $psm->delta_pl) }}" step="0.00001">
                @if($errors->has('delta_pl'))
                    <div class="invalid-feedback">
                        {{ $errors->first('delta_pl') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.delta_pl_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="peptide_with_modification_id">{{ trans('cruds.psm.fields.peptide_with_modification') }}</label>
                <select class="form-control select2 {{ $errors->has('peptide_with_modification') ? 'is-invalid' : '' }}" name="peptide_with_modification_id" id="peptide_with_modification_id">
                    @foreach($peptide_with_modifications as $id => $entry)
                        <option value="{{ $id }}" {{ (old('peptide_with_modification_id') ? old('peptide_with_modification_id') : $psm->peptide_with_modification->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('peptide_with_modification'))
                    <div class="invalid-feedback">
                        {{ $errors->first('peptide_with_modification') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.psm.fields.peptide_with_modification_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.psms.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $psm->id ?? 0 }}');
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