<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPeptidCategoryRequest;
use App\Http\Requests\StorePeptidCategoryRequest;
use App\Http\Requests\UpdatePeptidCategoryRequest;
use App\Models\PeptidCategory;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PeptidCategoryController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('peptid_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PeptidCategory::with(['created_by'])->select(sprintf('%s.*', (new PeptidCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'peptid_category_show';
                $editGate = 'peptid_category_edit';
                $deleteGate = 'peptid_category_delete';
                $crudRoutePart = 'peptid-categories';

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

        return view('admin.peptidCategories.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptid_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.peptidCategories.create');
    }

    public function store(StorePeptidCategoryRequest $request)
    {
        $peptidCategory = PeptidCategory::create($request->all());

        return redirect()->route('admin.peptid-categories.index');
    }

    public function edit(PeptidCategory $peptidCategory)
    {
        abort_if(Gate::denies('peptid_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidCategory->load('created_by');

        return view('admin.peptidCategories.edit', compact('peptidCategory'));
    }

    public function update(UpdatePeptidCategoryRequest $request, PeptidCategory $peptidCategory)
    {
        $peptidCategory->update($request->all());

        return redirect()->route('admin.peptid-categories.index');
    }

    public function show(PeptidCategory $peptidCategory)
    {
        abort_if(Gate::denies('peptid_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidCategory->load('created_by', 'categoryPeptides');

        return view('admin.peptidCategories.show', compact('peptidCategory'));
    }

    public function destroy(PeptidCategory $peptidCategory)
    {
        abort_if(Gate::denies('peptid_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyPeptidCategoryRequest $request)
    {
        PeptidCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
