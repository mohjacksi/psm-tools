@extends('layouts.frontend')
@section('styles')
    <style>

    </style>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js" rel="stylesheet" type="text/css" />
    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link href="https://nightly.datatables.net/select/css/select.dataTables.css?_=5362e195cd0aabf9b8ced350de2d5907.css"
    rel="stylesheet" type="text/css" />--}}
@endsection
@section('content')
    {{-- <div class="card">
        <div class="card-body">

            <div>
                <div class="row">
                    <div style="height: 300px;" class="col-6" id="samples"> </div>
                    <div style="height: 300px;" class="col-6" id="fractions"> </div>
                </div>

                <div class="row">
                    <div style="height: 300px;" class="col-4" id="projects"> </div>
                    <div style="height: 300px;" class="col-4" id="experiments"> </div>
                    <div style="height: 300px;" class="col-4" id="biological"> </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-5"> --}}

    <div class="card">

        <div class="table-responsive text-nowrap">
            <div class="card-header">
                @can('psm_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.psms.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.psm.title_singular') }}
                            </a>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                                {{ trans('global.app_csvImport') }}
                            </button>
                            @include('csvImport.modal', [
                                'model' => 'Psm',
                                'route' => 'admin.psms.parseCsvImport',
                            ])
                        </div>
                    </div>
                @endcan
            </div>


            <div class="table-responsive text-nowrap">
                <table class="table table-responsive text-nowrap table-stripd table-hover ajaxTable datatable datatable-Psm"
                    id="datatable-Psm">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.psm.fields.id') }}
                            </th>

                            <th>
                                {{ trans('cruds.psm.fields.project') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.experiment') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.biological_set') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.samples') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.fraction') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.peptide_with_modification') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.spectra') }}
                            </th>

                            <th>
                                {{ trans('cruds.psm.fields.scan_num') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.precursor') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.isotope_error') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.precursor_error') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.charge') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.de_novo_score') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.msgf_score') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.space_evalue') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.evalue') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.precursor_svm_score') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.psm_q_value') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.peptide_q_value') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.missed_clevage') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.experimental_pl') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.predicted_pl') }}
                            </th>
                            <th>
                                {{ trans('cruds.psm.fields.delta_pl') }}
                            </th>

                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('cruds.psm.fields.id') }}"
                                    size="4">
                            </td>
                            <td>
                                <select class="search" id="project_id">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach ($projects as $key => $item)
                                        <option value="{{ $item->name }}" idTag="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="search" id="experiment_id">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach ($experiments as $key => $item)
                                        <option value="{{ $item->name }}" idTag="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select  style="width: 100px;" class="search" id="biological_set_id">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach ($biological_sets as $key => $item)
                                        <option value="{{ $item->name }}" idTag="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="search" strict="true" id="sample_id">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach ($samples as $key => $item)
                                        <option value="{{ $item->name }}" idTag="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="search" style="width: 100px;">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach ($fractions as $key => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="search" style="width: 100px;">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach ($peptide_with_modifications as $key => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input size="10" class="search" type="text"
                                    placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    @parent

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>

    <script src="https://code.highcharts.com/adapters/prototype-adapter.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.25/dataRender/ellipsis.js" charset="utf8"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('psm_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.psms.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan
            var url = "";
            //url = url.replace(':id', id);
            let dtOverrideGlobals = {

                dom: 'lrtip',
                select: {
                    items: 'cell',
                    style: 'single'
                },
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{route('frontend.psms.index', ['sample' => request('sample'),'tissue' => request('tissue')])}}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row) {
                            return '<a href="/psms/' + data + '">' + data + '</a>';
                        }
                    },

                    {
                        data: 'project',
                        name: 'project.name',
                        render: function(data, type, row) {
                            data = JSON.parse(data);
                            return '<a href="/projects/' + data.id + '">' + data.name + '</a>';
                        }
                    },
                    {
                        data: 'experiment',
                        name: 'experiment.name',
                        render: function(data, type, row) {
                            data = JSON.parse(data);
                            return '<a href="/experiments/' + data.id + '">' + data.name + '</a>';
                        }
                    },
                    {
                        data: 'biological_set',
                        name: 'biological_set.name',
                       render: function(data, type, row) {
                            data = JSON.parse(data);
                           if (data.name.length > 20) {
                               return '<a href="/biological-sets/' + data.id + '">' + data.name.substr(0, 17) + '…' + '</a>';
                           }else {
                               return '<a href="/biological-sets/' + data.id + '">' + data.name + '</a>';
                           }
                        }

                    },
                    {
                        data: 'samples',
                        name: 'samples.name',
                        render: $.fn.dataTable.render.ellipsis(20)
                    },
                    {
                        data: 'fraction_name',
                        name: 'fraction.name',
                        render: $.fn.dataTable.render.ellipsis(20)
                    },

                    {
                        data: 'peptide_with_modification_name',
                        name: 'peptide_with_modification.name',
                        render: $.fn.dataTable.render.ellipsis(20)
                    },
                    {
                        data: 'spectra',
                        name: 'spectra',
                        render: $.fn.dataTable.render.ellipsis(20)
                    },

                    {
                        data: 'scan_num',
                        name: 'scan_num'
                    },
                    {
                        data: 'precursor',
                        name: 'precursor'
                    },
                    {
                        data: 'isotope_error',
                        name: 'isotope_error'
                    },
                    {
                        data: 'precursor_error',
                        name: 'precursor_error'
                    },
                    {
                        data: 'charge',
                        name: 'charge'
                    },
                    {
                        data: 'de_novo_score',
                        name: 'de_novo_score'
                    },
                    {
                        data: 'msgf_score',
                        name: 'msgf_score'
                    },
                    {
                        data: 'space_evalue',
                        name: 'space_evalue'
                    },
                    {
                        data: 'evalue',
                        name: 'evalue'
                    },
                    {
                        data: 'precursor_svm_score',
                        name: 'precursor_svm_score'
                    },
                    {
                        data: 'psm_q_value',
                        name: 'psm_q_value'
                    },
                    {
                        data: 'peptide_q_value',
                        name: 'peptide_q_value'
                    },
                    {
                        data: 'missed_clevage',
                        name: 'missed_clevage'
                    },
                    {
                        data: 'experimental_pl',
                        name: 'experimental_pl'
                    },
                    {
                        data: 'predicted_pl',
                        name: 'predicted_pl'
                    },
                    {
                        data: 'delta_pl',
                        name: 'delta_pl'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,

            };


            let table = $('.datatable-Psm').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw();
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })

            // table.on('select', function(e, dt, type, indexes) {
            //         dt.search(dt.cell(indexes[0].row, indexes[0].column).data()).draw();
            //     })
            //     .on('deselect', function(e, dt, type, indexes) {
            //         dt.search('').draw();
            //     })

        });

        $("#project_id").change(function() {
            var project_id = $('option:selected', this).attr('idTag');
            var experiment = $('#experiment_id');
            var sample = $('#sample_id');
            var biological_set = $('#biological_set_id');

            $.ajax({
                method: 'GET',
                url: "{{ route('frontend.experiments.experimentsOfProject') }}" + '/' + project_id,
                success: function(data) {
                    experiment.empty();
                    sample.empty();
                    biological_set.empty();
                    experiment.append('<option value="">'+ 'All' + '</option>');
                    sample.append('<option value="">'+ 'All' + '</option>');
                    biological_set.append('<option value="">'+ 'All' + '</option>');
                    for (var i = 0; i < data['experiments'].length; i++) {
                        experiment.append('<option value=' + data['experiments'][i].id + '>' + data[
                            'experiments'][i].name + '</option>');
                    };
                    for (var i = 0; i < data['samples'].length; i++) {
                        sample.append('<option value=' + data['samples'][i].id + '>' + data['samples'][
                            i
                        ].name + '</option>');
                    };
                    for (var i = 0; i < data['biologicalSets'].length; i++) {
                        biological_set.append('<option value=' + data['biologicalSets'][i].id + '>' + data[
                            'biologicalSets'][
                            i
                        ].name + '</option>');
                    };
                }
            })
        });

        $(document).ready(function() {
            var table = $('#datatable-Psm').DataTable();

            var projects = Highcharts.chart({
                chart: {
                    type: 'pie',
                    renderTo: 'projects'
                },
                title: {
                    text: 'Projects',
                },
                series: [{
                    data: chartData(table, 3),
                }, ],
            });

            var experiments = Highcharts.chart({
                chart: {
                    type: 'pie',
                    renderTo: 'experiments'
                },
                title: {
                    text: 'Experiments',
                },
                series: [{
                    data: chartData(table, 4),
                }, ],
            });

            var biological = Highcharts.chart({
                chart: {
                    type: 'pie',
                    renderTo: 'biological'
                },
                title: {
                    text: 'Biological Sets',
                },
                series: [{
                    data: chartData(table, 4),
                }, ],
            });

            var samples = Highcharts.chart({
                chart: {
                    type: 'pie',
                    renderTo: 'samples'
                },
                title: {
                    text: 'Samples',
                },
                series: [{
                    data: chartData(table, 6),
                }, ],
            });

            var fractions = Highcharts.chart({
                chart: {
                    type: 'pie',
                    renderTo: 'fractions'
                },
                title: {
                    text: 'Fractions',
                },
                series: [{
                    data: chartData(table, 7),
                }, ],
            });

            // On each draw, update the data in the chart
            table.on('draw', function() {
                projects.series[0].setData(chartData(table, 3));
                experiments.series[0].setData(chartData(table, 4));
                biological.series[0].setData(chartData(table, 5));
                samples.series[0].setData(chartData(table, 6));
                fractions.series[0].setData(chartData(table, 7));
            });
        });

        function chartData(table, index) {
            var counts = {};

            // Count the number of entries for each position
            table
                .column(index, {
                    search: 'applied'
                })
                .data()
                .each(function(val) {
                    if (counts[val]) {
                        counts[val] += 1;
                    } else {
                        counts[val] = 1;
                    }
                });
            // console.log(counts);
            // And map it to the format highcharts uses
            return $.map(counts, function(val, key) {
                if (index == 6) {
                    const result = key.split(/\r?\n/);
                    return $.map(result, function(resultval, resultkey) {
                        if (resultkey != '') {
                            return {
                                name: resultval,
                                y: val,
                            };
                        }
                    });
                } else {
                    return {
                        name: key,
                        y: val,
                    };
                }

            });
        }
         /*
        $.fn.dataTable.render.ellipsis = function () {
            return function (data, type, row) {
                // Return the original data for all orthogonal data types except display.
                if (type !== 'display') {
                    return data;
                }

                // Only truncate the text if it is longer than the cutoff.
                if (data.length > 100) {
                    return data.substr(0, 100) + '…';
                } else {
                    return data;
                }
            };
        };*/
    </script>
@endsection
