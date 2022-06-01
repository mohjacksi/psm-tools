<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFragmentMethodRequest;
use App\Http\Requests\StoreFragmentMethodRequest;
use App\Http\Requests\UpdateFragmentMethodRequest;
use App\Models\FragmentMethod;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FragmentMethodController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('fragment_method_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fragmentMethods = FragmentMethod::with(['created_by'])->get();

        $users = User::get();

        return view('frontend.fragmentMethods.index', compact('fragmentMethods', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('fragment_method_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.fragmentMethods.create');
    }

    public function store(StoreFragmentMethodRequest $request)
    {
        $fragmentMethod = FragmentMethod::create($request->all());

        return redirect()->route('frontend.fragment-methods.index');
    }

    public function edit(FragmentMethod $fragmentMethod)
    {
        abort_if(Gate::denies('fragment_method_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fragmentMethod->load('created_by');

        return view('frontend.fragmentMethods.edit', compact('fragmentMethod'));
    }

    public function update(UpdateFragmentMethodRequest $request, FragmentMethod $fragmentMethod)
    {
        $fragmentMethod->update($request->all());

        return redirect()->route('frontend.fragment-methods.index');
    }

    public function show(FragmentMethod $fragmentMethod)
    {
        abort_if(Gate::denies('fragment_method_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fragmentMethod->load('created_by', 'fragmentMethodBiologicalSets');

        return view('frontend.fragmentMethods.show', compact('fragmentMethod'));
    }

    public function destroy(FragmentMethod $fragmentMethod)
    {
        abort_if(Gate::denies('fragment_method_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fragmentMethod->delete();

        return back();
    }

    public function massDestroy(MassDestroyFragmentMethodRequest $request)
    {
        FragmentMethod::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
