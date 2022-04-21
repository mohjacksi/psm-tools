<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTissueRequest;
use App\Http\Requests\StoreTissueRequest;
use App\Http\Requests\UpdateTissueRequest;
use App\Models\Tissue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TissueController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('tissue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Tissue::query()->select(sprintf('%s.*', (new Tissue())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'tissue_show';
                $editGate = 'tissue_edit';
                $deleteGate = 'tissue_delete';
                $crudRoutePart = 'tissues';

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

        return view('admin.tissues.index');
    }

    public function create()
    {
        abort_if(Gate::denies('tissue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tissues.create');
    }

    public function store(StoreTissueRequest $request)
    {
        $tissue = Tissue::create($request->all());

        return redirect()->route('admin.tissues.index');
    }

    public function edit(Tissue $tissue)
    {
        abort_if(Gate::denies('tissue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tissues.edit', compact('tissue'));
    }

    public function update(UpdateTissueRequest $request, Tissue $tissue)
    {
        $tissue->update($request->all());

        return redirect()->route('admin.tissues.index');
    }

    public function show(Tissue $tissue)
    {
        abort_if(Gate::denies('tissue_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tissue->load('tissueSamples');

        return view('admin.tissues.show', compact('tissue'));
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
