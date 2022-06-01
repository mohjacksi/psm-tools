<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProteinTypeRequest;
use App\Http\Requests\StoreProteinTypeRequest;
use App\Http\Requests\UpdateProteinTypeRequest;
use App\Models\ProteinType;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProteinTypeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('protein_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteinTypes = ProteinType::with(['created_by'])->get();

        $users = User::get();

        return view('frontend.proteinTypes.index', compact('proteinTypes', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('protein_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.proteinTypes.create');
    }

    public function store(StoreProteinTypeRequest $request)
    {
        $proteinType = ProteinType::create($request->all());

        return redirect()->route('frontend.protein-types.index');
    }

    public function edit(ProteinType $proteinType)
    {
        abort_if(Gate::denies('protein_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteinType->load('created_by');

        return view('frontend.proteinTypes.edit', compact('proteinType'));
    }

    public function update(UpdateProteinTypeRequest $request, ProteinType $proteinType)
    {
        $proteinType->update($request->all());

        return redirect()->route('frontend.protein-types.index');
    }

    public function show(ProteinType $proteinType)
    {
        abort_if(Gate::denies('protein_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteinType->load('created_by');

        return view('frontend.proteinTypes.show', compact('proteinType'));
    }

    public function destroy(ProteinType $proteinType)
    {
        abort_if(Gate::denies('protein_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteinType->delete();

        return back();
    }

    public function massDestroy(MassDestroyProteinTypeRequest $request)
    {
        ProteinType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
