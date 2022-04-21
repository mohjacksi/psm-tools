<?php

namespace App\Http\Controllers\Frontend;

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

class BiologicalSetController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('biological_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSets = BiologicalSet::with(['experiment_biological_set', 'stripe', 'fragment_method'])->get();

        $experiment_biological_sets = ExperimentBiologicalSet::get();

        $stripes = Stripe::get();

        $fragment_methods = FragmentMethod::get();

        return view('frontend.biologicalSets.index', compact('biologicalSets', 'experiment_biological_sets', 'fragment_methods', 'stripes'));
    }

    public function create()
    {
        abort_if(Gate::denies('biological_set_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiment_biological_sets = ExperimentBiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stripes = Stripe::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.biologicalSets.create', compact('experiment_biological_sets', 'fragment_methods', 'stripes'));
    }

    public function store(StoreBiologicalSetRequest $request)
    {
        $biologicalSet = BiologicalSet::create($request->all());

        return redirect()->route('frontend.biological-sets.index');
    }

    public function edit(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiment_biological_sets = ExperimentBiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stripes = Stripe::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $biologicalSet->load('experiment_biological_set', 'stripe', 'fragment_method');

        return view('frontend.biologicalSets.edit', compact('biologicalSet', 'experiment_biological_sets', 'fragment_methods', 'stripes'));
    }

    public function update(UpdateBiologicalSetRequest $request, BiologicalSet $biologicalSet)
    {
        $biologicalSet->update($request->all());

        return redirect()->route('frontend.biological-sets.index');
    }

    public function show(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSet->load('experiment_biological_set', 'stripe', 'fragment_method');

        return view('frontend.biologicalSets.show', compact('biologicalSet'));
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
