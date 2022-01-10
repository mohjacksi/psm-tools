<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDnaRegionRequest;
use App\Http\Requests\StoreDnaRegionRequest;
use App\Http\Requests\UpdateDnaRegionRequest;
use App\Models\DnaRegion;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DnaRegionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dna_region_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dnaRegions = DnaRegion::all();

        return view('admin.dnaRegions.index', compact('dnaRegions'));
    }

    public function create()
    {
        abort_if(Gate::denies('dna_region_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dnaRegions.create');
    }

    public function store(StoreDnaRegionRequest $request)
    {
        $dnaRegion = DnaRegion::create($request->all());

        return redirect()->route('admin.dna-regions.index');
    }

    public function edit(DnaRegion $dnaRegion)
    {
        abort_if(Gate::denies('dna_region_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dnaRegions.edit', compact('dnaRegion'));
    }

    public function update(UpdateDnaRegionRequest $request, DnaRegion $dnaRegion)
    {
        $dnaRegion->update($request->all());

        return redirect()->route('admin.dna-regions.index');
    }

    public function show(DnaRegion $dnaRegion)
    {
        abort_if(Gate::denies('dna_region_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dnaRegion->load('dnaLocationTranscripts');

        return view('admin.dnaRegions.show', compact('dnaRegion'));
    }

    public function destroy(DnaRegion $dnaRegion)
    {
        abort_if(Gate::denies('dna_region_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dnaRegion->delete();

        return back();
    }

    public function massDestroy(MassDestroyDnaRegionRequest $request)
    {
        DnaRegion::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
