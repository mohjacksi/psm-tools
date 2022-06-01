<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySampleConditionRequest;
use App\Http\Requests\StoreSampleConditionRequest;
use App\Http\Requests\UpdateSampleConditionRequest;
use App\Models\SampleCondition;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SampleConditionController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('sample_condition_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sampleConditions = SampleCondition::all();

        return view('frontend.sampleConditions.index', compact('sampleConditions'));
    }

    public function create()
    {
        abort_if(Gate::denies('sample_condition_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.sampleConditions.create');
    }

    public function store(StoreSampleConditionRequest $request)
    {
        $sampleCondition = SampleCondition::create($request->all());

        return redirect()->route('frontend.sample-conditions.index');
    }

    public function edit(SampleCondition $sampleCondition)
    {
        abort_if(Gate::denies('sample_condition_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.sampleConditions.edit', compact('sampleCondition'));
    }

    public function update(UpdateSampleConditionRequest $request, SampleCondition $sampleCondition)
    {
        $sampleCondition->update($request->all());

        return redirect()->route('frontend.sample-conditions.index');
    }

    public function show(SampleCondition $sampleCondition)
    {
        abort_if(Gate::denies('sample_condition_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.sampleConditions.show', compact('sampleCondition'));
    }

    public function destroy(SampleCondition $sampleCondition)
    {
        abort_if(Gate::denies('sample_condition_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sampleCondition->delete();

        return back();
    }

    public function massDestroy(MassDestroySampleConditionRequest $request)
    {
        SampleCondition::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
