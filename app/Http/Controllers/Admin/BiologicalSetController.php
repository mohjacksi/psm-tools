<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBiologicalSetRequest;
use App\Http\Requests\StoreBiologicalSetRequest;
use App\Http\Requests\UpdateBiologicalSetRequest;
use App\Models\BiologicalSet;
use App\Models\ExperimentBiologicalSet;
use App\Models\FragmentMethod;
use App\Models\Stripe;
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
            $query = BiologicalSet::with(['experiment_biological_set', 'stripe', 'fragment_method'])->select(sprintf('%s.*', (new BiologicalSet())->table));
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
            $table->addColumn('experiment_biological_set_name', function ($row) {
                return $row->experiment_biological_set ? $row->experiment_biological_set->name : '';
            });

            $table->addColumn('stripe_name', function ($row) {
                return $row->stripe ? $row->stripe->name : '';
            });

            $table->addColumn('fragment_method_name', function ($row) {
                return $row->fragment_method ? $row->fragment_method->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'experiment_biological_set', 'stripe', 'fragment_method']);

            return $table->make(true);
        }

        $experiment_biological_sets = ExperimentBiologicalSet::get();
        $stripes                    = Stripe::get();
        $fragment_methods           = FragmentMethod::get();

        return view('admin.biologicalSets.index', compact('experiment_biological_sets', 'stripes', 'fragment_methods'));
    }

    public function create()
    {
        abort_if(Gate::denies('biological_set_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiment_biological_sets = ExperimentBiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stripes = Stripe::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.biologicalSets.create', compact('experiment_biological_sets', 'fragment_methods', 'stripes'));
    }

    public function store(StoreBiologicalSetRequest $request)
    {
        $biologicalSet = BiologicalSet::create($request->all());

        return redirect()->route('admin.biological-sets.index');
    }

    public function edit(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiment_biological_sets = ExperimentBiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stripes = Stripe::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $biologicalSet->load('experiment_biological_set', 'stripe', 'fragment_method');

        return view('admin.biologicalSets.edit', compact('biologicalSet', 'experiment_biological_sets', 'fragment_methods', 'stripes'));
    }

    public function update(UpdateBiologicalSetRequest $request, BiologicalSet $biologicalSet)
    {
        $biologicalSet->update($request->all());

        return redirect()->route('admin.biological-sets.index');
    }

    public function show(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSet->load('experiment_biological_set', 'stripe', 'fragment_method');

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
