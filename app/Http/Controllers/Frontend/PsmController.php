<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPsmRequest;
use App\Http\Requests\StorePsmRequest;
use App\Http\Requests\UpdatePsmRequest;
use App\Models\Fraction;
use App\Models\Psm;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PsmController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $psms = Psm::with(['fraction'])->get();

        $fractions = Fraction::get();

        return view('frontend.psms.index', compact('fractions', 'psms'));
    }

    public function create()
    {
        abort_if(Gate::denies('psm_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fractions = Fraction::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.psms.create', compact('fractions'));
    }

    public function store(StorePsmRequest $request)
    {
        $psm = Psm::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $psm->id]);
        }

        return redirect()->route('frontend.psms.index');
    }

    public function edit(Psm $psm)
    {
        abort_if(Gate::denies('psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fractions = Fraction::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psm->load('fraction');

        return view('frontend.psms.edit', compact('fractions', 'psm'));
    }

    public function update(UpdatePsmRequest $request, Psm $psm)
    {
        $psm->update($request->all());

        return redirect()->route('frontend.psms.index');
    }

    public function show(Psm $psm)
    {
        abort_if(Gate::denies('psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $psm->load('fraction', 'psmChannelPsms', 'psmPeptidePsms');

        return view('frontend.psms.show', compact('psm'));
    }

    public function destroy(Psm $psm)
    {
        abort_if(Gate::denies('psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $psm->delete();

        return back();
    }

    public function massDestroy(MassDestroyPsmRequest $request)
    {
        Psm::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('psm_create') && Gate::denies('psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Psm();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
