@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.uploadForm.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.upload-forms.store') }}" enctype="multipart/form-data"
                id="psmForm">
                @csrf
                <input type="hidden" value="{{ Auth()->user()->id }}" name="created_by_id">
                <div class="form-group">
                    <label class="required" for="project_id">{{ trans('cruds.uploadForm.fields.project') }}</label>
                    <div class="input-group mb-3">
                        <div class="mr-2" style="width: 90%">
                            <select
                                class="project_id form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}"
                                name="project_id" id="project_id" required>
                                @foreach ($projects as $id => $entry)
                                    <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>
                                        {{ $entry }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#projectModal"
                            id="button-addon2">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    @if ($errors->has('project'))
                        <div class="invalid-feedback">
                            {{ $errors->first('project') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.uploadForm.fields.project_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                        for="experiment_id">{{ trans('cruds.uploadForm.fields.experiment') }}</label>
                    <div class="input-group mb-3">
                        <div class="mr-2" style="width: 90%">
                            <select class="form-control select2 {{ $errors->has('experiment') ? 'is-invalid' : '' }}"
                                name="experiment_id" id="experiment_id" required>
                                @foreach ($experiments as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('experiment_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#experimentModal"
                            id="button-addon2">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    @if ($errors->has('experiment'))
                        <div class="invalid-feedback">
                            {{ $errors->first('experiment') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.uploadForm.fields.experiment_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="sample_number">Number of Samples</label>
                    <input type="number" class="form-control {{ $errors->has('sample_number') ? 'is-invalid' : '' }}"
                        name="sample_number" id="sample_number" onchange="sampleInputs()">
                    @if ($errors->has('sample_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('sample_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.uploadForm.fields.experiment_helper') }}</span>
                </div>
                <table class="table table-bordered table-hover" id="sample_table" style="display: none;">
                    <thead>
                        <tr>
                            <th class="text-center">
                                Sample
                                <button type="button" class="btn btn-primary small" data-toggle="modal"
                                    data-target="#sampleModal" id="button-addon2" style="float: right">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                            <th class="text-center">channel</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
                <select class="form-control" id="sample_id" style="display: none;">
                    @foreach ($samples as $id => $entry)
                        <option value="{{ $id }}">{{ $entry }}</option>
                    @endforeach
                </select>
                {{-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="psm_file">{{ trans('cruds.peptide.fields.peptide_file') }}</label>
                        <input class="form-control" type="file" name="peptide_file">
                        @if ($errors->has('peptide_file'))
                            <div class="invalid-feedback">
                                {{ $errors->first('peptide_file') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="psm_file">{{ trans('cruds.protein.fields.protein_file') }}</label>
                        <input class="form-control" type="file" name="protein_file">
                        @if ($errors->has('protein_file'))
                            <div class="invalid-feedback">
                                {{ $errors->first('protein_file') }}
                            </div>
                        @endif
                    </div>
                </div> --}}
               
                <div class="form-group">
                    <label class="required" for="psm_file">{{ trans('cruds.uploadForm.fields.psm_file') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('psm_file') ? 'is-invalid' : '' }}"
                        id="psm_file-dropzone">
                    </div>
                    @if ($errors->has('psm_file'))
                        <div class="invalid-feedback">
                            {{ $errors->first('psm_file') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.uploadForm.fields.psm_file_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="peptide_file">{{ trans('cruds.peptide.fields.peptide_file') }}</label>
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
                    <label for="protein_file">{{ trans('cruds.protein.fields.protein_file') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('protein_file') ? 'is-invalid' : '' }}" id="protein_file-dropzone">
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

    {{-- project Model --}}
    <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data"
                        id="projectForm">
                        @csrf
                        <input type="hidden" value="{{ Auth()->user()->id }}" name="created_by_id">
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.project.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', '') }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.project.fields.description') }}</label>
                            <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                                id="description">{!! old('description') !!}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('public') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="public" value="0">
                                <input class="form-check-input" type="checkbox" name="public" id="public" value="1"
                                    {{ old('public', 0) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="public">{{ trans('cruds.project.fields.public') }}</label>
                            </div>
                            @if ($errors->has('public'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('public') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.public_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary projectClose" data-dismiss="modal" hidden>Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- experiment Modal --}}
    <div class="modal fade" id="experimentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Experiment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.experiments.store') }}" enctype="multipart/form-data"
                        id="experimentForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.experiment.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', '') }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.experiment.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="project_id">{{ trans('cruds.experiment.fields.project') }}</label>
                            <select
                                class="project_id form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}"
                                name="project_id" id="project_id">
                                @foreach ($projects as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('project'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('project') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.experiment.fields.project_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="date">{{ trans('cruds.experiment.fields.date') }}</label>
                            <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                                name="date" id="date" value="{{ old('date') }}">
                            @if ($errors->has('date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.experiment.fields.date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.experiment.fields.method') }}</label>
                            <select class="form-control {{ $errors->has('method') ? 'is-invalid' : '' }}" name="method"
                                id="method">
                                <option value disabled {{ old('method', null) === null ? 'selected' : '' }}>
                                    {{ trans('global.pleaseSelect') }}</option>
                                @foreach (App\Models\Experiment::METHOD_SELECT as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('method', '') === (string) $key ? 'selected' : '' }}>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('method'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('method') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.experiment.fields.method_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('allowed_missed_cleavage') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="allowed_missed_cleavage" value="0">
                                <input class="form-check-input" type="checkbox" name="allowed_missed_cleavage"
                                    id="allowed_missed_cleavage" value="1"
                                    {{ old('allowed_missed_cleavage', 0) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="allowed_missed_cleavage">{{ trans('cruds.experiment.fields.allowed_missed_cleavage') }}</label>
                            </div>
                            @if ($errors->has('allowed_missed_cleavage'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('allowed_missed_cleavage') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.experiment.fields.allowed_missed_cleavage_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label
                                for="expression_threshold">{{ trans('cruds.experiment.fields.expression_threshold') }}</label>
                            <input class="form-control {{ $errors->has('expression_threshold') ? 'is-invalid' : '' }}"
                                type="number" name="expression_threshold" id="expression_threshold"
                                value="{{ old('expression_threshold', '') }}" step="0.0001">
                            @if ($errors->has('expression_threshold'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expression_threshold') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.experiment.fields.expression_threshold_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="species_id">{{ trans('cruds.experiment.fields.species') }}</label>
                            <select class="form-control select2 {{ $errors->has('species') ? 'is-invalid' : '' }}"
                                name="species_id" id="species_id">
                                @foreach ($species as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('species_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('species'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('species') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.experiment.fields.species_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label
                                for="reference_protein_source">{{ trans('cruds.experiment.fields.reference_protein_source') }}</label>
                            <input
                                class="form-control {{ $errors->has('reference_protein_source') ? 'is-invalid' : '' }}"
                                type="text" name="reference_protein_source" id="reference_protein_source"
                                value="{{ old('reference_protein_source', '') }}">
                            @if ($errors->has('reference_protein_source'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference_protein_source') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.experiment.fields.reference_protein_source_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label
                                for="other_protein_source">{{ trans('cruds.experiment.fields.other_protein_source') }}</label>
                            <input class="form-control {{ $errors->has('other_protein_source') ? 'is-invalid' : '' }}"
                                type="text" name="other_protein_source" id="other_protein_source"
                                value="{{ old('other_protein_source', '') }}">
                            @if ($errors->has('other_protein_source'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('other_protein_source') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.experiment.fields.other_protein_source_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="psm_file_name">{{ trans('cruds.experiment.fields.psm_file_name') }}</label>
                            <input class="form-control {{ $errors->has('psm_file_name') ? 'is-invalid' : '' }}"
                                type="text" name="psm_file_name" id="psm_file_name"
                                value="{{ old('psm_file_name', '') }}">
                            @if ($errors->has('psm_file_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('psm_file_name') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.experiment.fields.psm_file_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="metadata">{{ trans('cruds.experiment.fields.metadata') }}</label>
                            <textarea class="form-control ckeditor {{ $errors->has('metadata') ? 'is-invalid' : '' }}" name="metadata"
                                id="metadata">{!! old('metadata') !!}</textarea>
                            @if ($errors->has('metadata'))
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary experimentClose" data-dismiss="modal"
                        hidden>Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- sample Modal --}}
    <div class="modal fade" id="sampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Sample</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.samples.store') }}" enctype="multipart/form-data"
                        id="sampleForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.sample.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', '') }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.sample.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="details">{{ trans('cruds.sample.fields.details') }}</label>
                            <textarea class="form-control ckeditor {{ $errors->has('details') ? 'is-invalid' : '' }}" name="details"
                                id="details">{!! old('details') !!}</textarea>
                            @if ($errors->has('details'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('details') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.sample.fields.details_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="replicate_number">{{ trans('cruds.sample.fields.replicate_number') }}</label>
                            <input class="form-control {{ $errors->has('replicate_number') ? 'is-invalid' : '' }}"
                                type="number" name="replicate_number" id="replicate_number"
                                value="{{ old('replicate_number', '') }}" step="1">
                            @if ($errors->has('replicate_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('replicate_number') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.sample.fields.replicate_number_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="project_id">{{ trans('cruds.sample.fields.project') }}</label>
                            <select
                                class="project_id form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}"
                                name="project_id" id="project_id">
                                @foreach ($projects as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('project'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('project') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.sample.fields.project_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="channels">{{ trans('cruds.sample.fields.channel') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all"
                                    style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all"
                                    style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2 {{ $errors->has('channels') ? 'is-invalid' : '' }}"
                                name="channels[]" id="channels" multiple>
                                @foreach ($channels as $id => $channel)
                                    <option value="{{ $id }}"
                                        {{ in_array($id, old('channels', [])) ? 'selected' : '' }}>{{ $channel }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('channels'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('channels') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.sample.fields.channel_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="species_id">{{ trans('cruds.sample.fields.species') }}</label>
                            <select class="form-control select2 {{ $errors->has('species') ? 'is-invalid' : '' }}"
                                name="species_id" id="species_id">
                                @foreach ($species as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('species_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('species'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('species') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.sample.fields.species_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="tissue_id">{{ trans('cruds.sample.fields.tissue') }}</label>
                            <select class="form-control select2 {{ $errors->has('tissue') ? 'is-invalid' : '' }}"
                                name="tissue_id" id="tissue_id">
                                @foreach ($tissues as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('tissue_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tissue'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tissue') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.sample.fields.tissue_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="sample_condition_id">{{ trans('cruds.sample.fields.sample_condition') }}</label>
                            <select
                                class="form-control select2 {{ $errors->has('sample_condition') ? 'is-invalid' : '' }}"
                                name="sample_condition_id" id="sample_condition_id">
                                @foreach ($sample_conditions as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('sample_condition_id') == $id ? 'selected' : '' }}>{{ $entry }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('sample_condition'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sample_condition') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.sample.fields.sample_condition_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary sampleClose" data-dismiss="modal" hidden>Close</button>
                </div>
            </div>
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
            success: function(file, response) {
                console.log(response);
                $('#psmForm').find('input[name="psm_file"]').remove()
                $('#psmForm').append('<input type="hidden" name="psm_file" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('#psmForm').find('input[name="psm_file"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($uploadForm) && $uploadForm->psm_file)
                    var file = {!! json_encode($uploadForm->psm_file) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('#psmForm').append('<input type="hidden" name="psm_file" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
      $('#psmForm').find('input[name="peptide_file"]').remove()
      $('#psmForm').append('<input type="hidden" name="peptide_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('#psmForm').find('input[name="peptide_file"]').remove()
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


Dropzone.options.proteinFileDropzone = {
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
      $('#psmForm').find('input[name="protein_file"]').remove()
      $('#psmForm').append('<input type="hidden" name="protein_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('#psmForm').find('input[name="protein_file"]').remove()
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


        function sampleInputs() {
            var sample_number = $('#sample_number').val();
            $('#sample_table').css('display', 'none');
            if (sample_number > 0) {
                $('#sample_table').css('display', '');
                $("#sample_table").find('tbody').empty();
                for (let i = 0; i < sample_number; i++) {
                    var sample_id = $("#sample_id").clone();
                    sample_id.css('display', '');
                    sample_id.attr('id', '');
                    sample_id.attr('name', 'samples[' + (i + 1) + ']');
                    sample_id.addClass('select2');
                    $("#sample_table").find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(sample_id)
                            )
                            .append($('<td>')
                                .append('<input type="text" class="form-control" name="chennels[' + (i + 1) +
                                    ']" placeholder="Chennel ' + (i + 1) + '">')
                            )
                        );
                }
            }
        }

        $("#projectForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    $('#projectModal .projectClose').click();
                    $('.modal-backdrop').attr('class', '');
                    $('.project_id').append('<option value="' + data.id + '">' + data.name +
                        '</option>')
                }
            });

        });

        $("#experimentForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    $('#experimentModal .experimentClose').click();
                    $('.modal-backdrop').attr('class', '');
                    $('#experiment_id').append('<option value="' + data.id + '">' + data.name +
                        '</option>')
                }
            });

        });

        $("#sampleForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    $('#sampleModal .sampleClose').click();
                    $('.modal-backdrop').attr('class', '');
                    $('#sample_id').append('<option value="' + data.id + '">' + data.name +
                    '</option>');
                    sampleInputs();
                }
            });

        });

        // change experiments and samples on change project
        $("#psmForm #project_id").change(function() {
            var project_id = $(this).val();
            var experiment = $('#experiment_id');
            var sample = $('#sample_id');
            if (project_id != '') {
                $('.modal-body .project_id option[value=""]').remove();
                $('.modal-body .project_id option[value="' + project_id + '"]').prop('selected', true);
            } else {
                var $options = $("#psmForm #project_id > option").clone();
                $(".modal-body .project_id").empty();
                $('.modal-body .project_id').append($options);
                project_id = 0;
            }
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.experiments.experimentsOfProject') }}" + '/' + project_id,
                success: function(data) {
                    experiment.empty();
                    sample.empty();
                    for (var i = 0; i < data['experiments'].length; i++) {
                        experiment.append('<option value=' + data['experiments'][i].id + '>' + data[
                            'experiments'][i].name + '</option>');
                    };
                    for (var i = 0; i < data['samples'].length; i++) {
                        sample.append('<option value=' + data['samples'][i].id + '>' + data['samples'][
                            i].name + '</option>');
                    };
                    sampleInputs();
                }
            })
        });
    </script>
@endsection
