<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\Admin\PersonResource;
use App\Models\Person;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('person_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PersonResource(Person::with(['project', 'projects'])->get());
    }

    public function store(StorePersonRequest $request)
    {
        $person = Person::create($request->all());

        return (new PersonResource($person))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Person $person)
    {
        abort_if(Gate::denies('person_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PersonResource($person->load(['project', 'projects']));
    }

    public function update(UpdatePersonRequest $request, Person $person)
    {
        $person->update($request->all());

        return (new PersonResource($person))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Person $person)
    {
        abort_if(Gate::denies('person_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $person->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
