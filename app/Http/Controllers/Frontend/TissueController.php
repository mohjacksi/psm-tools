<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTissueRequest;
use App\Http\Requests\StoreTissueRequest;
use App\Http\Requests\UpdateTissueRequest;
use App\Models\Tissue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TissueController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('tissue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tissues = Tissue::all();

        return view('frontend.tissues.index', compact('tissues'));
    }

    public function create()
    {
        abort_if(Gate::denies('tissue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.tissues.create');
    }

    public function store(StoreTissueRequest $request)
    {
        $tissue = Tissue::create($request->all());

        return redirect()->route('frontend.tissues.index');
    }

    public function edit(Tissue $tissue)
    {
        abort_if(Gate::denies('tissue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.tissues.edit', compact('tissue'));
    }

    public function update(UpdateTissueRequest $request, Tissue $tissue)
    {
        $tissue->update($request->all());

        return redirect()->route('frontend.tissues.index');
    }

    public function show(Tissue $tissue)
    {
        abort_if(Gate::denies('tissue_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tissue->load('tissueSamples');

        return view('frontend.tissues.show', compact('tissue'));
    }

    public function destroy(Tissue $tissue)
    {
        abort_if(Gate::denies('tissue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tissue->delete();

        return back();
    }

    public function massDestroy(MassDestroyTissueRequest $request)
    {
        Tissue::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
