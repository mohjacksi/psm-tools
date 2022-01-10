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
use Yajra\DataTables\Facades\DataTables;

class DnaRegionController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('dna_region_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DnaRegion::query()->select(sprintf('%s.*', (new DnaRegion())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'dna_region_show';
                $editGate = 'dna_region_edit';
                $deleteGate = 'dna_region_delete';
                $crudRoutePart = 'dna-regions';

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

        return view('admin.dnaRegions.index');
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
