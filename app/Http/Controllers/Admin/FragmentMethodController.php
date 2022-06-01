<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class FragmentMethodController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('fragment_method_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FragmentMethod::with(['created_by'])->select(sprintf('%s.*', (new FragmentMethod())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'fragment_method_show';
                $editGate = 'fragment_method_edit';
                $deleteGate = 'fragment_method_delete';
                $crudRoutePart = 'fragment-methods';

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

        return view('admin.fragmentMethods.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('fragment_method_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.fragmentMethods.create');
    }

    public function store(StoreFragmentMethodRequest $request)
    {
        $fragmentMethod = FragmentMethod::create($request->all());

        return redirect()->route('admin.fragment-methods.index');
    }

    public function edit(FragmentMethod $fragmentMethod)
    {
        abort_if(Gate::denies('fragment_method_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fragmentMethod->load('created_by');

        return view('admin.fragmentMethods.edit', compact('fragmentMethod'));
    }

    public function update(UpdateFragmentMethodRequest $request, FragmentMethod $fragmentMethod)
    {
        $fragmentMethod->update($request->all());

        return redirect()->route('admin.fragment-methods.index');
    }

    public function show(FragmentMethod $fragmentMethod)
    {
        abort_if(Gate::denies('fragment_method_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fragmentMethod->load('created_by', 'fragmentMethodBiologicalSets');

        return view('admin.fragmentMethods.show', compact('fragmentMethod'));
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
