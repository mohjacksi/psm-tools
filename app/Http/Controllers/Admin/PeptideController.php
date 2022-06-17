<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPeptideRequest;
use App\Http\Requests\StorePeptideRequest;
use App\Http\Requests\UpdatePeptideRequest;
use App\Models\PeptidCategory;
use App\Models\Peptide;
use App\Models\Sample;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;


class PeptideController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('peptide_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Peptide::with(['category', 'created_by'])->select(sprintf('%s.*', (new Peptide())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'peptide_show';
                $editGate = 'peptide_edit';
                $deleteGate = 'peptide_delete';
                $crudRoutePart = 'peptides';

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
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });
            $table->editColumn('canonical', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->canonical ? 'checked' : null) . '>';
            });
            $table->editColumn('canonical_frame_value', function ($row) {
                return $row->canonical_frame_value ? $row->canonical_frame_value : '';
            });
            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'canonical', 'category']);

            return $table->make(true);
        }

        $peptid_categories = PeptidCategory::get();
        $users             = User::get();

        return view('admin.peptides.index', compact('peptid_categories', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = PeptidCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.peptides.create', compact('categories'));
    }

    public function store(StorePeptideRequest $request)
    {
        $peptide = Peptide::create($request->all());

        return redirect()->route('admin.peptides.index');
    }

    public function edit(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = PeptidCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptide->load('category', 'created_by');

        return view('admin.peptides.edit', compact('categories', 'peptide'));
    }

    public function update(UpdatePeptideRequest $request, Peptide $peptide)
    {
        $peptide->update($request->all());

        return redirect()->route('admin.peptides.index');
    }

    public function show(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptide->load('category', 'created_by', 'peptideProteins');

        return view('admin.peptides.show', compact('peptide'));
    }

    public function destroy(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptide->delete();

        return back();
    }

    public function massDestroy(MassDestroyPeptideRequest $request)
    {
        Peptide::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function uploadTsv(Request $request)
    {
        // dd($peptideAsArray[0]);
        $peptideFile = storage_path('tmp/uploads/' . basename($request->input('peptide_file')));
        $peptideAsArray = Excel::toArray('', $peptideFile);
        $peptideFields = array(
            "Peptide",
            "Protein_types",
            "Samples",
            "Category",
            "is_canonical_frame",
        );
        $fieldsOrder = [];
        foreach ($peptideFields as $field) {
            $fieldsOrder[$field] = array_search($field, $peptideAsArray[0][0]);
        }
        foreach ($peptideAsArray[0] as $key => $peptide) {
            if ($key > 0) {
                $category = PeptidCategory::where('name', $peptide[$fieldsOrder['Category']])->firstOrCreate(
                    [
                        'name' => $peptide[$fieldsOrder['Category']],
                        'created_by_id' => auth()->user()->id
                    ]
                );
                $samples = explode(",", $peptide[$fieldsOrder['Samples']]);
                if(count($samples) > 0){
                    foreach($samples as $sampleName){
                        $sample = Sample::where('name', $sampleName)->firstOrCreate(
                            [
                                'name' => $sampleName,
                                'created_by_id' => auth()->user()->id
                            ]
                        );
                    }
                }
                if($peptide[$fieldsOrder['is_canonical_frame']] != 'non_canonical'){
                    $canonical = 1;
                    $canonical_frame_value = $peptide[$fieldsOrder['is_canonical_frame']];
                }else{
                    $canonical = 0;
                    $canonical_frame_value = null;
                }
                
                $newPeptide = Peptide::where('sequence', $peptide[$fieldsOrder['Peptide']])->firstOrCreate(
                    [
                        'sequence' => $peptide[$fieldsOrder['Peptide']],
                        'canonical' => $canonical,
                        'canonical_frame_value' => $canonical_frame_value,
                        'category_id' => $category->id,
                        'created_by_id' => auth()->user()->id
                    ]
                );
            }
        }

        return redirect()->route('admin.peptides.index');
    }
}
