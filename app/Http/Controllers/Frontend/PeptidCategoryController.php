<?php

namespace App\Http\Controllers\Frontend;

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

class PeptidCategoryController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('peptid_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidCategories = PeptidCategory::with(['created_by'])->get();

        $users = User::get();

        return view('frontend.peptidCategories.index', compact('peptidCategories', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptid_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.peptidCategories.create');
    }

    public function store(StorePeptidCategoryRequest $request)
    {
        $peptidCategory = PeptidCategory::create($request->all());

        return redirect()->route('frontend.peptid-categories.index');
    }

    public function edit(PeptidCategory $peptidCategory)
    {
        abort_if(Gate::denies('peptid_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidCategory->load('created_by');

        return view('frontend.peptidCategories.edit', compact('peptidCategory'));
    }

    public function update(UpdatePeptidCategoryRequest $request, PeptidCategory $peptidCategory)
    {
        $peptidCategory->update($request->all());

        return redirect()->route('frontend.peptid-categories.index');
    }

    public function show(PeptidCategory $peptidCategory)
    {
        abort_if(Gate::denies('peptid_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidCategory->load('created_by');

        return view('frontend.peptidCategories.show', compact('peptidCategory'));
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
