<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySpeciesRequest;
use App\Http\Requests\StoreSpeciesRequest;
use App\Http\Requests\UpdateSpeciesRequest;
use App\Models\Species;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpeciesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('species_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $speciess = Species::all();

        return view('frontend.speciess.index', compact('speciess'));
    }

    public function create()
    {
        abort_if(Gate::denies('species_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.speciess.create');
    }

    public function store(StoreSpeciesRequest $request)
    {
        $species = Species::create($request->all());

        return redirect()->route('frontend.speciess.index');
    }

    public function edit(Species $species)
    {
        abort_if(Gate::denies('species_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.speciess.edit', compact('species'));
    }

    public function update(UpdateSpeciesRequest $request, Species $species)
    {
        $species->update($request->all());

        return redirect()->route('frontend.speciess.index');
    }

    public function show(Species $species)
    {
        abort_if(Gate::denies('species_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.speciess.show', compact('species'));
    }

    public function destroy(Species $species)
    {
        abort_if(Gate::denies('species_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $species->delete();

        return back();
    }

    public function massDestroy(MassDestroySpeciesRequest $request)
    {
        Species::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
