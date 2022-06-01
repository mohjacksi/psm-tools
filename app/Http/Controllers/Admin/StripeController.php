<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStripeRequest;
use App\Http\Requests\StoreStripeRequest;
use App\Http\Requests\UpdateStripeRequest;
use App\Models\Stripe;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StripeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('stripe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Stripe::query()->select(sprintf('%s.*', (new Stripe())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'stripe_show';
                $editGate = 'stripe_edit';
                $deleteGate = 'stripe_delete';
                $crudRoutePart = 'stripes';

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

        return view('admin.stripes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('stripe_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.stripes.create');
    }

    public function store(StoreStripeRequest $request)
    {
        $stripe = Stripe::create($request->all());

        return redirect()->route('admin.stripes.index');
    }

    public function edit(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.stripes.edit', compact('stripe'));
    }

    public function update(UpdateStripeRequest $request, Stripe $stripe)
    {
        $stripe->update($request->all());

        return redirect()->route('admin.stripes.index');
    }

    public function show(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stripe->load('stripeBiologicalSets');

        return view('admin.stripes.show', compact('stripe'));
    }

    public function destroy(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stripe->delete();

        return back();
    }

    public function massDestroy(MassDestroyStripeRequest $request)
    {
        Stripe::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
