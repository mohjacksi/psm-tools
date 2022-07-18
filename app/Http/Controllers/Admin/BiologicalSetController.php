<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBiologicalSetRequest;
use App\Http\Requests\StoreBiologicalSetRequest;
use App\Http\Requests\UpdateBiologicalSetRequest;
use App\Models\BiologicalSet;
use App\Models\Experiment;
use App\Models\FragmentMethod;
use App\Models\Strip;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BiologicalSetController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('biological_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BiologicalSet::with(['experiment', 'strip', 'fragment_method', 'created_by'])->select(sprintf('%s.*', (new BiologicalSet())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'biological_set_show';
                $editGate = 'biological_set_edit';
                $deleteGate = 'biological_set_delete';
                $crudRoutePart = 'biological-sets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('labeling_number', function ($row) {
                return $row->labeling_number ? $row->labeling_number : '';
            });
            $table->editColumn('experiment', function ($row) {
                return $row->experiment ? $row->experiment->name : '';
                // $labels = [];
                // foreach ($row->experiments as $experiment) {
                //     $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $experiment->name);
                // }
                // return implode(' ', $labels);
            });
            $table->addColumn('strip_name', function ($row) {
                return $row->strip ? $row->strip->name : '';
            });

            $table->addColumn('fragment_method_name', function ($row) {
                return $row->fragment_method ? $row->fragment_method->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'experiment', 'strip', 'fragment_method']);

            return $table->make(true);
        }

        $experiments      = Experiment::get();
        $strips          = Strip::get();
        $fragment_methods = FragmentMethod::get();
        $users            = User::get();

        return view('admin.biologicalSets.index', compact('experiments', 'strips', 'fragment_methods', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('biological_set_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id');

        $strips = Strip::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.biologicalSets.create', compact('experiments', 'fragment_methods', 'strips'));
    }

    public function store(StoreBiologicalSetRequest $request)
    {
        $biologicalSet = BiologicalSet::create($request->all());
        $biologicalSet->experiments()->sync($request->input('experiments', []));

        return redirect()->route('admin.biological-sets.index');
    }

    public function edit(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id');

        $strips = Strip::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $biologicalSet->load('experiments', 'strip', 'fragment_method', 'created_by');

        return view('admin.biologicalSets.edit', compact('biologicalSet', 'experiments', 'fragment_methods', 'strips'));
    }

    public function update(UpdateBiologicalSetRequest $request, BiologicalSet $biologicalSet)
    {
        $biologicalSet->update($request->all());
        $biologicalSet->experiments()->sync($request->input('experiments', []));

        return redirect()->route('admin.biological-sets.index');
    }

    public function show(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSet->load('experiments', 'strip', 'fragment_method', 'created_by');

        return view('admin.biologicalSets.show', compact('biologicalSet'));
    }

    public function destroy(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSet->delete();

        return back();
    }

    public function massDestroy(MassDestroyBiologicalSetRequest $request)
    {
        BiologicalSet::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
