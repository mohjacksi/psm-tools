<?php

namespace App\Http\Controllers\Frontend;

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

class BiologicalSetController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('biological_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSets = BiologicalSet::with(['experiments', 'strip', 'fragment_method', 'created_by'])->get();

        $experiments = Experiment::get();

        $strips = Strip::get();

        $fragment_methods = FragmentMethod::get();

        $users = User::get();

        return view('frontend.biologicalSets.index', compact('biologicalSets', 'experiments', 'fragment_methods', 'strips', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('biological_set_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id');

        $strips = Strip::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.biologicalSets.create', compact('experiments', 'fragment_methods', 'strips'));
    }

    public function store(StoreBiologicalSetRequest $request)
    {
        $biologicalSet = BiologicalSet::create($request->all());
        $biologicalSet->experiments()->sync($request->input('experiments', []));

        return redirect()->route('frontend.biological-sets.index');
    }

    public function edit(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id');

        $strips = Strip::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fragment_methods = FragmentMethod::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $biologicalSet->load('experiments', 'strip', 'fragment_method', 'created_by');

        return view('frontend.biologicalSets.edit', compact('biologicalSet', 'experiments', 'fragment_methods', 'strips'));
    }

    public function update(UpdateBiologicalSetRequest $request, BiologicalSet $biologicalSet)
    {
        $biologicalSet->update($request->all());
        $biologicalSet->experiments()->sync($request->input('experiments', []));

        return redirect()->route('frontend.biological-sets.index');
    }

    public function show(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSet->load('experiments', 'strip', 'fragment_method', 'created_by');

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
