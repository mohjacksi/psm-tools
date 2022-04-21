<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPersonRequest;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\Models\Project;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PersonController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('person_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Person::with(['project', 'projects'])->select(sprintf('%s.*', (new Person())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'person_show';
                $editGate = 'person_edit';
                $deleteGate = 'person_delete';
                $crudRoutePart = 'people';

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

            $table->editColumn('sex', function ($row) {
                return $row->sex ? Person::SEX_RADIO[$row->sex] : '';
            });
            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->addColumn('projects_name', function ($row) {
                return $row->projects ? $row->projects->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project', 'projects']);

            return $table->make(true);
        }

        $projects = Project::get();

        return view('admin.people.index', compact('projects'));
    }

    public function create()
    {
        abort_if(Gate::denies('person_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.people.create', compact('projects'));
    }

    public function store(StorePersonRequest $request)
    {
        $person = Person::create($request->all());

        return redirect()->route('admin.people.index');
    }

    public function edit(Person $person)
    {
        abort_if(Gate::denies('person_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person->load('project', 'projects');

        return view('admin.people.edit', compact('person', 'projects'));
    }

    public function update(UpdatePersonRequest $request, Person $person)
    {
        $person->update($request->all());

        return redirect()->route('admin.people.index');
    }

    public function show(Person $person)
    {
        abort_if(Gate::denies('person_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $person->load('project', 'projects', 'personSamples');

        return view('admin.people.show', compact('person'));
    }

    public function destroy(Person $person)
    {
        abort_if(Gate::denies('person_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $person->delete();

        return back();
    }

    public function massDestroy(MassDestroyPersonRequest $request)
    {
        Person::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
