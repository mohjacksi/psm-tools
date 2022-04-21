<?php

namespace App\Http\Controllers\Frontend;

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

class PersonController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('person_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::with(['project', 'projects'])->get();

        $projects = Project::get();

        return view('frontend.people.index', compact('people', 'projects'));
    }

    public function create()
    {
        abort_if(Gate::denies('person_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.people.create', compact('projects'));
    }

    public function store(StorePersonRequest $request)
    {
        $person = Person::create($request->all());

        return redirect()->route('frontend.people.index');
    }

    public function edit(Person $person)
    {
        abort_if(Gate::denies('person_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person->load('project', 'projects');

        return view('frontend.people.edit', compact('person', 'projects'));
    }

    public function update(UpdatePersonRequest $request, Person $person)
    {
        $person->update($request->all());

        return redirect()->route('frontend.people.index');
    }

    public function show(Person $person)
    {
        abort_if(Gate::denies('person_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $person->load('project', 'projects');

        return view('frontend.people.show', compact('person'));
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
