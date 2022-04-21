<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFractionRequest;
use App\Http\Requests\StoreFractionRequest;
use App\Http\Requests\UpdateFractionRequest;
use App\Models\BiologicalSet;
use App\Models\Fraction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FractionController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('fraction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fractions = Fraction::with(['biological_set'])->get();

        $biological_sets = BiologicalSet::get();

        return view('frontend.fractions.index', compact('biological_sets', 'fractions'));
    }

    public function create()
    {
        abort_if(Gate::denies('fraction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.fractions.create', compact('biological_sets'));
    }

    public function store(StoreFractionRequest $request)
    {
        $fraction = Fraction::create($request->all());

        return redirect()->route('frontend.fractions.index');
    }

    public function edit(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fraction->load('biological_set');

        return view('frontend.fractions.edit', compact('biological_sets', 'fraction'));
    }

    public function update(UpdateFractionRequest $request, Fraction $fraction)
    {
        $fraction->update($request->all());

        return redirect()->route('frontend.fractions.index');
    }

    public function show(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fraction->load('biological_set');

        return view('frontend.fractions.show', compact('fraction'));
    }

    public function destroy(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fraction->delete();

        return back();
    }

    public function massDestroy(MassDestroyFractionRequest $request)
    {
        Fraction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
