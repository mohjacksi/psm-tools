<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class ProteinTypeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('protein_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProteinType::with(['created_by'])->select(sprintf('%s.*', (new ProteinType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'protein_type_show';
                $editGate = 'protein_type_edit';
                $deleteGate = 'protein_type_delete';
                $crudRoutePart = 'protein-types';

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

        $users = User::get();

        return view('admin.proteinTypes.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('protein_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.proteinTypes.create');
    }

    public function store(StoreProteinTypeRequest $request)
    {
        $proteinType = ProteinType::create($request->all());

        return redirect()->route('admin.protein-types.index');
    }

    public function edit(ProteinType $proteinType)
    {
        abort_if(Gate::denies('protein_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteinType->load('created_by');

        return view('admin.proteinTypes.edit', compact('proteinType'));
    }

    public function update(UpdateProteinTypeRequest $request, ProteinType $proteinType)
    {
        $proteinType->update($request->all());

        return redirect()->route('admin.protein-types.index');
    }

    public function show(ProteinType $proteinType)
    {
        abort_if(Gate::denies('protein_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteinType->load('created_by', 'typeProteins');

        return view('admin.proteinTypes.show', compact('proteinType'));
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
