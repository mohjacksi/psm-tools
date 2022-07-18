<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStripRequest;
use App\Http\Requests\StoreStripRequest;
use App\Http\Requests\UpdateStripRequest;
use App\Models\Strip;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StripController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('strip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Strip::query()->select(sprintf('%s.*', (new Strip())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'strip_show';
                $editGate = 'strip_edit';
                $deleteGate = 'strip_delete';
                $crudRoutePart = 'strips';

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

        return view('admin.strips.index');
    }

    public function create()
    {
        abort_if(Gate::denies('strip_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.strips.create');
    }

    public function store(StoreStripRequest $request)
    {
        $strip = Strip::create($request->all());

        return redirect()->route('admin.strips.index');
    }

    public function edit(Strip $strip)
    {
        abort_if(Gate::denies('strip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.strips.edit', compact('strip'));
    }

    public function update(UpdateStripRequest $request, Strip $strip)
    {
        $strip->update($request->all());

        return redirect()->route('admin.strips.index');
    }

    public function show(Strip $strip)
    {
        abort_if(Gate::denies('strip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $strip->load('stripBiologicalSets');

        return view('admin.strips.show', compact('strip'));
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
