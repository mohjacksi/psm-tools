<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPsmRequest;
use App\Http\Requests\StorePsmRequest;
use App\Http\Requests\UpdatePsmRequest;
use App\Models\Psm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PsmsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $psms = Psm::all();

        return view('admin.psms.index', compact('psms'));
    }

    public function create()
    {
        abort_if(Gate::denies('psm_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.psms.create');
    }

    public function store(StorePsmRequest $request)
    {
        $psm = Psm::create($request->all());

        return redirect()->route('admin.psms.index');
    }

    public function edit(Psm $psm)
    {
        abort_if(Gate::denies('psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.psms.edit', compact('psm'));
    }

    public function update(UpdatePsmRequest $request, Psm $psm)
    {
        $psm->update($request->all());

        return redirect()->route('admin.psms.index');
    }

    public function show(Psm $psm)
    {
        abort_if(Gate::denies('psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.psms.show', compact('psm'));
    }

    public function destroy(Psm $psm)
    {
        abort_if(Gate::denies('psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $psm->delete();

        return back();
    }

    public function massDestroy(MassDestroyPsmRequest $request)
    {
        Psm::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
