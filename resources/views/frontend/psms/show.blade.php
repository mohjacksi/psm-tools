@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.psm.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered table-stripd">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $psm->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.spectra') }}
                                        </th>
                                        <td>
                                            {{ $psm->spectra }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.fraction') }}
                                        </th>
                                        <td>
                                            {{ $psm->fraction->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.peptide_modification') }}
                                        </th>
                                        <td>
                                            {!! $psm->peptide_modification !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.scan_num') }}
                                        </th>
                                        <td>
                                            {{ $psm->scan_num }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.precursor') }}
                                        </th>
                                        <td>
                                            {{ $psm->precursor }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.isotope_error') }}
                                        </th>
                                        <td>
                                            {{ $psm->isotope_error }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.precursor_error') }}
                                        </th>
                                        <td>
                                            {{ $psm->precursor_error }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.charge') }}
                                        </th>
                                        <td>
                                            {{ $psm->charge }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.de_novo_score') }}
                                        </th>
                                        <td>
                                            {{ $psm->de_novo_score }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.msgf_score') }}
                                        </th>
                                        <td>
                                            {{ $psm->msgf_score }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.space_evalue') }}
                                        </th>
                                        <td>
                                            {{ $psm->space_evalue }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.evalue') }}
                                        </th>
                                        <td>
                                            {{ $psm->evalue }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.precursor_svm_score') }}
                                        </th>
                                        <td>
                                            {{ $psm->precursor_svm_score }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.psm_q_value') }}
                                        </th>
                                        <td>
                                            {{ $psm->psm_q_value }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.peptide_q_value') }}
                                        </th>
                                        <td>
                                            {{ $psm->peptide_q_value }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.missed_clevage') }}
                                        </th>
                                        <td>
                                            {{ $psm->missed_clevage }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.experimental_pl') }}
                                        </th>
                                        <td>
                                            {{ $psm->experimental_pl }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.predicted_pl') }}
                                        </th>
                                        <td>
                                            {{ $psm->predicted_pl }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.delta_pl') }}
                                        </th>
                                        <td>
                                            {{ $psm->delta_pl }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.psm.fields.peptide_with_modification') }}
                                        </th>
                                        <td>
                                            {{ $psm->peptide_with_modification->name ?? '' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
