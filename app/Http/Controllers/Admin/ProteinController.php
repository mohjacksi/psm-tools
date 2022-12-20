<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProteinRequest;
use App\Http\Requests\StoreProteinRequest;
use App\Http\Requests\UpdateProteinRequest;
use App\Models\Sample;
use App\Models\Peptide;
use App\Models\Protein;
use App\Models\ProteinType;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ProteinController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('protein_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Protein::with(['peptide', 'type', 'created_by'])->select(sprintf('%s.*', (new Protein())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'protein_show';
                $editGate = 'protein_edit';
                $deleteGate = 'protein_delete';
                $crudRoutePart = 'proteins';

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
            $table->addColumn('peptide_sequence', function ($row) {
                return $row->peptide ? $row->peptide->sequence : '';
            });

            $table->addColumn('type_name', function ($row) {
                return $row->type ? $row->type->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'peptide', 'type']);

            return $table->make(true);
        }

        $peptides      = Peptide::get();
        $protein_types = ProteinType::get();
        $users         = User::get();

        return view('admin.proteins.index', compact('peptides', 'protein_types', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('protein_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = ProteinType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.proteins.create', compact('peptides', 'types'));
    }

    public function store(StoreProteinRequest $request)
    {
        $protein = Protein::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $protein->id]);
        }

        return redirect()->route('admin.proteins.index');
    }

    public function edit(Protein $protein)
    {
        abort_if(Gate::denies('protein_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = ProteinType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $protein->load('peptide', 'type', 'created_by');

        return view('admin.proteins.edit', compact('peptides', 'protein', 'types'));
    }

    public function update(UpdateProteinRequest $request, Protein $protein)
    {
        $protein->update($request->all());

        return redirect()->route('admin.proteins.index');
    }

    public function show(Protein $protein)
    {
        abort_if(Gate::denies('protein_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $protein->load('peptide', 'type', 'created_by');

        return view('admin.proteins.show', compact('protein'));
    }

    public function destroy(Protein $protein)
    {
        abort_if(Gate::denies('protein_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $protein->delete();

        return back();
    }

    public function massDestroy(MassDestroyProteinRequest $request)
    {
        Protein::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('protein_create') && Gate::denies('protein_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Protein();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    // proteinID  ProteinName    proteinSequence    matchingPeptideSequences


    public function uploadTsv(Request $request)
    {
        // dd($request->input('protein_file'));
        if ($request->input('project_id')) {
            $project_id = $request->input('project_id');
        } else {
            $project_id = null;
        }
        $proteinFile = storage_path('tmp/uploads/' . basename($request->input('protein_file')));
        $proteinAsArray = Excel::toArray('', $proteinFile);
        $proteinFields = array(
            "ProteinID",
            "Name",
            "Class_codes",
            "Samples",
            "Peptides",
        );
        $fieldsOrder = [];
        foreach ($proteinFields as $field) {
            $fieldsOrder[$field] = array_search($field, $proteinAsArray[0][0]);
        }


        foreach ($proteinAsArray[0] as $key => $protein) {
            if ($key > 0) {
                $type_ids = [];
                $types = explode(',', $protein[$fieldsOrder['Class_codes']]);
                foreach ($types as $key => $value) {
                    $type = ProteinType::where('name', $value)->firstOrCreate(
                        [
                            'name' => $value,
                            'created_by_id' => auth()->user()->id
                        ]
                    );
                    $type_ids[] = $type->id;
                }

                $peptide_ids = [];
                $peptides = explode(',', $protein[$fieldsOrder['Peptides']]);
                foreach ($peptides as $key => $value) {
                    $peptide = Peptide::where('sequence', $value)->firstOrCreate(
                        [
                            'sequence' => $value,
                            'created_by_id' => auth()->user()->id
                        ]
                    );
                    $peptide_ids[] = $peptide->id;
                }


                $samples = explode(",", $protein[$fieldsOrder['Samples']]);
                if (count($samples) > 0) {
                    foreach ($samples as $sampleName) {
                        $sample = Sample::where('name', $sampleName)->firstOrCreate(
                            [
                                'name' => $sampleName,
                                'project_id' => $project_id,
                                'created_by_id' => auth()->user()->id
                            ]
                        );
                    }
                }
                $newProtein = Protein::updateOrCreate(
                    [
                    'sequence' => $protein[$fieldsOrder['ProteinID']],
                    ],
                    [
                        'sequence' => $protein[$fieldsOrder['ProteinID']],
                        'name' => $protein[$fieldsOrder['Name']],
                        'type_id' => $type->id,
                        'created_by_id' => auth()->user()->id
                    ]
                );

                $newProtein->peptides()->sync($peptide_ids);
                $newProtein->types()->sync($type_ids);
            }
        }



        return redirect()->route('admin.proteins.index');
    }
}
