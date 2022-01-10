<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProteinRequest;
use App\Http\Requests\StoreProteinRequest;
use App\Http\Requests\UpdateProteinRequest;
use App\Models\Protein;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProteinsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('protein_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteins = Protein::all();

        return view('admin.proteins.index', compact('proteins'));
    }

    public function create()
    {
        abort_if(Gate::denies('protein_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.proteins.create');
    }

    public function store(StoreProteinRequest $request)
    {
        $protein = Protein::create($request->all());

        return redirect()->route('admin.proteins.index');
    }

    public function edit(Protein $protein)
    {
        abort_if(Gate::denies('protein_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.proteins.edit', compact('protein'));
    }

    public function update(UpdateProteinRequest $request, Protein $protein)
    {
        $protein->update($request->all());

        return redirect()->route('admin.proteins.index');
    }

    public function show(Protein $protein)
    {
        abort_if(Gate::denies('protein_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.proteins.show', compact('protein'));
    }

    public function destroy(Protein $protein)
    {
        abort_if(Gate::denies('protein_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $protein->delete();

        return back();
    }

    public function massDestroy(MassDestroyProteinRequest $request)
    {
        Protein::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
