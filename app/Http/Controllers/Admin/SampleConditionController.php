<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySampleConditionRequest;
use App\Http\Requests\StoreSampleConditionRequest;
use App\Http\Requests\UpdateSampleConditionRequest;
use App\Models\SampleCondition;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SampleConditionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sample_condition_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SampleCondition::query()->select(sprintf('%s.*', (new SampleCondition())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sample_condition_show';
                $editGate = 'sample_condition_edit';
                $deleteGate = 'sample_condition_delete';
                $crudRoutePart = 'sample-conditions';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.sampleConditions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sample_condition_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sampleConditions.create');
    }

    public function store(StoreSampleConditionRequest $request)
    {
        $sampleCondition = SampleCondition::create($request->all());

        return redirect()->route('admin.sample-conditions.index');
    }

    public function edit(SampleCondition $sampleCondition)
    {
        abort_if(Gate::denies('sample_condition_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sampleConditions.edit', compact('sampleCondition'));
    }

    public function update(UpdateSampleConditionRequest $request, SampleCondition $sampleCondition)
    {
        $sampleCondition->update($request->all());

        return redirect()->route('admin.sample-conditions.index');
    }

    public function show(SampleCondition $sampleCondition)
    {
        abort_if(Gate::denies('sample_condition_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sampleCondition->load('sampleConditionSamples');

        return view('admin.sampleConditions.show', compact('sampleCondition'));
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
