<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStripRequest;
use App\Http\Requests\StoreStripRequest;
use App\Http\Requests\UpdateStripRequest;
use App\Models\Strip;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('strip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $strips = Strip::all();

        return view('frontend.strips.index', compact('strips'));
    }

    public function create()
    {
        abort_if(Gate::denies('strip_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.strips.create');
    }

    public function store(StoreStripRequest $request)
    {
        $strip = Strip::create($request->all());

        return redirect()->route('frontend.strips.index');
    }

    public function edit(Strip $strip)
    {
        abort_if(Gate::denies('strip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.strips.edit', compact('strip'));
    }

    public function update(UpdateStripRequest $request, Strip $strip)
    {
        $strip->update($request->all());

        return redirect()->route('frontend.strips.index');
    }

    public function show(Strip $strip)
    {
        abort_if(Gate::denies('strip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $strip->load('stripBiologicalSets');

        return view('frontend.strips.show', compact('strip'));
    }

    public function destroy(Strip $strip)
    {
        abort_if(Gate::denies('strip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $strip->delete();

        return back();
    }

    public function massDestroy(MassDestroyStripRequest $request)
    {
        Strip::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
