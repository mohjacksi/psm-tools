<?php

use App\Models\Channel;
use App\Models\Fraction;
use App\Models\Peptide;
use App\Models\PeptideWithModification;
use App\Models\Protein;
use App\Models\Psm;
use Illuminate\Support\Facades\DB;

Route::get('/clear', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');

    dd("done");
});

Route::get('/clear-data', function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    Psm::truncate();
    DB::table('channel_sample')->delete();
    DB::table('peptid_categories')->delete();
    DB::table('protein_types')->delete();
    DB::table('protein_protein_type')->delete();
    DB::table('upload_forms')->delete();
    DB::table('audit_logs')->delete();
    DB::table('biological_sets')->delete();
    DB::table('peptides_proteins')->delete();
    Protein::truncate();
    Channel::truncate();
    Peptide::truncate();
    Fraction::truncate();
    PeptideWithModification::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');



    dd("PSM, Peptide, Channel, Channel-Sample tables truncated successfully!");
});
Route::view('/', 'welcome')->name('main');
Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::resource('roles', 'RolesController', ['except' => ['destroy']]);

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Project
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::post('projects/media', 'ProjectController@storeMedia')->name('projects.storeMedia');
    Route::post('projects/ckmedia', 'ProjectController@storeCKEditorImages')->name('projects.storeCKEditorImages');
    Route::post('projects/parse-csv-import', 'ProjectController@parseCsvImport')->name('projects.parseCsvImport');
    Route::post('projects/process-csv-import', 'ProjectController@processCsvImport')->name('projects.processCsvImport');
    Route::resource('projects', 'ProjectController');

    // Sample
    Route::delete('samples/destroy', 'SampleController@massDestroy')->name('samples.massDestroy');
    Route::post('samples/media', 'SampleController@storeMedia')->name('samples.storeMedia');
    Route::post('samples/ckmedia', 'SampleController@storeCKEditorImages')->name('samples.storeCKEditorImages');
    Route::post('samples/parse-csv-import', 'SampleController@parseCsvImport')->name('samples.parseCsvImport');
    Route::post('samples/process-csv-import', 'SampleController@processCsvImport')->name('samples.processCsvImport');
    Route::resource('samples', 'SampleController');

    // Dna Region
    Route::delete('dna-regions/destroy', 'DnaRegionController@massDestroy')->name('dna-regions.massDestroy');
    Route::post('dna-regions/parse-csv-import', 'DnaRegionController@parseCsvImport')->name('dna-regions.parseCsvImport');
    Route::post('dna-regions/process-csv-import', 'DnaRegionController@processCsvImport')->name('dna-regions.processCsvImport');
    Route::resource('dna-regions', 'DnaRegionController');

    // Transcript
    Route::delete('transcripts/destroy', 'TranscriptController@massDestroy')->name('transcripts.massDestroy');
    Route::post('transcripts/parse-csv-import', 'TranscriptController@parseCsvImport')->name('transcripts.parseCsvImport');
    Route::post('transcripts/process-csv-import', 'TranscriptController@processCsvImport')->name('transcripts.processCsvImport');
    Route::resource('transcripts', 'TranscriptController');

    // Psm
    Route::get('psms/samples', 'PsmController@getSamples')->name('psms.getSamples');
    Route::delete('psms/destroy', 'PsmController@massDestroy')->name('psms.massDestroy');
    Route::post('psms/media', 'PsmController@storeMedia')->name('psms.storeMedia');
    Route::post('psms/ckmedia', 'PsmController@storeCKEditorImages')->name('psms.storeCKEditorImages');
    Route::post('psms/parse-csv-import', 'PsmController@parseCsvImport')->name('psms.parseCsvImport');
    Route::post('psms/process-csv-import', 'PsmController@processCsvImport')->name('psms.processCsvImport');
    Route::resource('psms', 'PsmController');

    // Experiment
    Route::get('experiments/project/{project_id?}', 'ExperimentController@experimentsOfProject')->name('experiments.experimentsOfProject');
    Route::delete('experiments/destroy', 'ExperimentController@massDestroy')->name('experiments.massDestroy');
    Route::post('experiments/media', 'ExperimentController@storeMedia')->name('experiments.storeMedia');
    Route::post('experiments/ckmedia', 'ExperimentController@storeCKEditorImages')->name('experiments.storeCKEditorImages');
    Route::post('experiments/parse-csv-import', 'ExperimentController@parseCsvImport')->name('experiments.parseCsvImport');
    Route::post('experiments/process-csv-import', 'ExperimentController@processCsvImport')->name('experiments.processCsvImport');
    Route::resource('experiments', 'ExperimentController');

    // Biological Set
    Route::delete('biological-sets/destroy', 'BiologicalSetController@massDestroy')->name('biological-sets.massDestroy');
    Route::post('biological-sets/parse-csv-import', 'BiologicalSetController@parseCsvImport')->name('biological-sets.parseCsvImport');
    Route::post('biological-sets/process-csv-import', 'BiologicalSetController@processCsvImport')->name('biological-sets.processCsvImport');
    Route::resource('biological-sets', 'BiologicalSetController');

    // Fraction
    Route::delete('fractions/destroy', 'FractionController@massDestroy')->name('fractions.massDestroy');
    Route::post('fractions/parse-csv-import', 'FractionController@parseCsvImport')->name('fractions.parseCsvImport');
    Route::post('fractions/process-csv-import', 'FractionController@processCsvImport')->name('fractions.processCsvImport');
    Route::resource('fractions', 'FractionController');

    // Fragment Method
    Route::delete('fragment-methods/destroy', 'FragmentMethodController@massDestroy')->name('fragment-methods.massDestroy');
    Route::post('fragment-methods/parse-csv-import', 'FragmentMethodController@parseCsvImport')->name('fragment-methods.parseCsvImport');
    Route::post('fragment-methods/process-csv-import', 'FragmentMethodController@processCsvImport')->name('fragment-methods.processCsvImport');
    Route::resource('fragment-methods', 'FragmentMethodController');

    // Strip
    Route::delete('strips/destroy', 'StripController@massDestroy')->name('strips.massDestroy');
    Route::post('strips/parse-csv-import', 'StripController@parseCsvImport')->name('strips.parseCsvImport');
    Route::post('strips/process-csv-import', 'StripController@processCsvImport')->name('strips.processCsvImport');
    Route::resource('strips', 'StripController');

    // Channel
    Route::delete('channels/destroy', 'ChannelController@massDestroy')->name('channels.massDestroy');
    Route::post('channels/parse-csv-import', 'ChannelController@parseCsvImport')->name('channels.parseCsvImport');
    Route::post('channels/process-csv-import', 'ChannelController@processCsvImport')->name('channels.processCsvImport');
    Route::resource('channels', 'ChannelController');

    // Protein
    Route::get('proteins/uploadTsv', function () {
        return view('admin.proteins.uploadTsv');
    })->name('proteins.uploadTsv');
    Route::post('proteins/uploadTsv', 'ProteinController@uploadTsv')->name('proteins.saveUploadTsv');
    Route::get('batch/{id}', 'ProteinController@batch');

    Route::delete('proteins/destroy', 'ProteinController@massDestroy')->name('proteins.massDestroy');
    Route::post('proteins/media', 'ProteinController@storeMedia')->name('proteins.storeMedia');
    Route::post('proteins/ckmedia', 'ProteinController@storeCKEditorImages')->name('proteins.storeCKEditorImages');
    Route::post('proteins/parse-csv-import', 'ProteinController@parseCsvImport')->name('proteins.parseCsvImport');
    Route::post('proteins/process-csv-import', 'ProteinController@processCsvImport')->name('proteins.processCsvImport');
    Route::resource('proteins', 'ProteinController');

    // Peptide
    Route::get('peptides/uploadTsv', function () {
        return view('admin.peptides.uploadTsv');
    })->name('peptides.uploadTsv');
    Route::post('peptides/uploadTsv', 'PeptideController@uploadTsv')->name('peptides.saveUploadTsv');

    Route::delete('peptides/destroy', 'PeptideController@massDestroy')->name('peptides.massDestroy');
    Route::post('peptides/parse-csv-import', 'PeptideController@parseCsvImport')->name('peptides.parseCsvImport');
    Route::post('peptides/process-csv-import', 'PeptideController@processCsvImport')->name('peptides.processCsvImport');
    Route::resource('peptides', 'PeptideController');

    // Tissue
    Route::delete('tissues/destroy', 'TissueController@massDestroy')->name('tissues.massDestroy');
    Route::post('tissues/parse-csv-import', 'TissueController@parseCsvImport')->name('tissues.parseCsvImport');
    Route::post('tissues/process-csv-import', 'TissueController@processCsvImport')->name('tissues.processCsvImport');
    Route::resource('tissues', 'TissueController');

    // Sample Condition
    Route::delete('sample-conditions/destroy', 'SampleConditionController@massDestroy')->name('sample-conditions.massDestroy');
    Route::post('sample-conditions/parse-csv-import', 'SampleConditionController@parseCsvImport')->name('sample-conditions.parseCsvImport');
    Route::post('sample-conditions/process-csv-import', 'SampleConditionController@processCsvImport')->name('sample-conditions.processCsvImport');
    Route::resource('sample-conditions', 'SampleConditionController');

    // Species
    Route::delete('speciess/destroy', 'SpeciesController@massDestroy')->name('speciess.massDestroy');
    Route::post('speciess/parse-csv-import', 'SpeciesController@parseCsvImport')->name('speciess.parseCsvImport');
    Route::post('speciess/process-csv-import', 'SpeciesController@processCsvImport')->name('speciess.processCsvImport');
    Route::resource('speciess', 'SpeciesController');

    // Peptide With Modification
    Route::delete('peptide-with-modifications/destroy', 'PeptideWithModificationController@massDestroy')->name('peptide-with-modifications.massDestroy');
    Route::post('peptide-with-modifications/parse-csv-import', 'PeptideWithModificationController@parseCsvImport')->name('peptide-with-modifications.parseCsvImport');
    Route::post('peptide-with-modifications/process-csv-import', 'PeptideWithModificationController@processCsvImport')->name('peptide-with-modifications.processCsvImport');
    Route::resource('peptide-with-modifications', 'PeptideWithModificationController');

    // Peptid Category
    Route::delete('peptid-categories/destroy', 'PeptidCategoryController@massDestroy')->name('peptid-categories.massDestroy');
    Route::post('peptid-categories/parse-csv-import', 'PeptidCategoryController@parseCsvImport')->name('peptid-categories.parseCsvImport');
    Route::post('peptid-categories/process-csv-import', 'PeptidCategoryController@processCsvImport')->name('peptid-categories.processCsvImport');
    Route::resource('peptid-categories', 'PeptidCategoryController');

    // Protein Type
    Route::delete('protein-types/destroy', 'ProteinTypeController@massDestroy')->name('protein-types.massDestroy');
    Route::post('protein-types/parse-csv-import', 'ProteinTypeController@parseCsvImport')->name('protein-types.parseCsvImport');
    Route::post('protein-types/process-csv-import', 'ProteinTypeController@processCsvImport')->name('protein-types.processCsvImport');
    Route::resource('protein-types', 'ProteinTypeController');

    // Upload Form
    Route::delete('upload-forms/destroy', 'UploadFormController@massDestroy')->name('upload-forms.massDestroy');
    Route::post('upload-forms/media', 'UploadFormController@storeMedia')->name('upload-forms.storeMedia');
    Route::post('upload-forms/ckmedia', 'UploadFormController@storeCKEditorImages')->name('upload-forms.storeCKEditorImages');
    Route::get('batch_psm/{batch_psm}/batch_peptide/{batch_peptide}/batch_protein/{batch_protein}','UploadFormController@progess');
    Route::resource('upload-forms', 'UploadFormController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::view('/network', 'network')->name('network');
    Route::view('/graph', 'graph')->name('graph');

    Route::get('/tables', function () {
        return view('layouts.tables');
    })->name('tables');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::resource('roles', 'RolesController', ['except' => ['destroy']]);

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Project
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::post('projects/media', 'ProjectController@storeMedia')->name('projects.storeMedia');
    Route::post('projects/ckmedia', 'ProjectController@storeCKEditorImages')->name('projects.storeCKEditorImages');
    Route::resource('projects', 'ProjectController');

    // Sample
    Route::delete('samples/destroy', 'SampleController@massDestroy')->name('samples.massDestroy');
    Route::post('samples/media', 'SampleController@storeMedia')->name('samples.storeMedia');
    Route::post('samples/ckmedia', 'SampleController@storeCKEditorImages')->name('samples.storeCKEditorImages');
    Route::resource('samples', 'SampleController');

    // Dna Region
    Route::delete('dna-regions/destroy', 'DnaRegionController@massDestroy')->name('dna-regions.massDestroy');
    Route::resource('dna-regions', 'DnaRegionController');

    // Transcript
    Route::delete('transcripts/destroy', 'TranscriptController@massDestroy')->name('transcripts.massDestroy');
    Route::resource('transcripts', 'TranscriptController');

    // Psm
    Route::delete('psms/destroy', 'PsmController@massDestroy')->name('psms.massDestroy');
    Route::post('psms/media', 'PsmController@storeMedia')->name('psms.storeMedia');
    Route::post('psms/ckmedia', 'PsmController@storeCKEditorImages')->name('psms.storeCKEditorImages');
    Route::resource('psms', 'PsmController');

    // Experiment
    Route::get('experiments/project/{project_id?}', 'ExperimentController@experimentsOfProject')->name('experiments.experimentsOfProject');
    Route::delete('experiments/destroy', 'ExperimentController@massDestroy')->name('experiments.massDestroy');
    Route::post('experiments/media', 'ExperimentController@storeMedia')->name('experiments.storeMedia');
    Route::post('experiments/ckmedia', 'ExperimentController@storeCKEditorImages')->name('experiments.storeCKEditorImages');
    Route::resource('experiments', 'ExperimentController');

    // Biological Set
    Route::delete('biological-sets/destroy', 'BiologicalSetController@massDestroy')->name('biological-sets.massDestroy');
    Route::resource('biological-sets', 'BiologicalSetController');

    // Fraction
    Route::delete('fractions/destroy', 'FractionController@massDestroy')->name('fractions.massDestroy');
    Route::resource('fractions', 'FractionController');

    // Fragment Method
    Route::delete('fragment-methods/destroy', 'FragmentMethodController@massDestroy')->name('fragment-methods.massDestroy');
    Route::resource('fragment-methods', 'FragmentMethodController');

    // Strip
    Route::delete('strips/destroy', 'StripController@massDestroy')->name('strips.massDestroy');
    Route::resource('strips', 'StripController');

    // Channel
    Route::delete('channels/destroy', 'ChannelController@massDestroy')->name('channels.massDestroy');
    Route::resource('channels', 'ChannelController');

    // Protein
    Route::delete('proteins/destroy', 'ProteinController@massDestroy')->name('proteins.massDestroy');
    Route::post('proteins/media', 'ProteinController@storeMedia')->name('proteins.storeMedia');
    Route::post('proteins/ckmedia', 'ProteinController@storeCKEditorImages')->name('proteins.storeCKEditorImages');
    Route::resource('proteins', 'ProteinController');

    // Peptide
    Route::delete('peptides/destroy', 'PeptideController@massDestroy')->name('peptides.massDestroy');
    Route::resource('peptides', 'PeptideController');

    // Tissue
    Route::delete('tissues/destroy', 'TissueController@massDestroy')->name('tissues.massDestroy');
    Route::resource('tissues', 'TissueController');

    // Sample Condition
    Route::delete('sample-conditions/destroy', 'SampleConditionController@massDestroy')->name('sample-conditions.massDestroy');
    Route::resource('sample-conditions', 'SampleConditionController');

    // Species
    Route::delete('speciess/destroy', 'SpeciesController@massDestroy')->name('speciess.massDestroy');
    Route::resource('speciess', 'SpeciesController');

    // Peptide With Modification
    Route::delete('peptide-with-modifications/destroy', 'PeptideWithModificationController@massDestroy')->name('peptide-with-modifications.massDestroy');
    Route::resource('peptide-with-modifications', 'PeptideWithModificationController');

    // Peptid Category
    Route::delete('peptid-categories/destroy', 'PeptidCategoryController@massDestroy')->name('peptid-categories.massDestroy');
    Route::resource('peptid-categories', 'PeptidCategoryController');

    // Protein Type
    Route::delete('protein-types/destroy', 'ProteinTypeController@massDestroy')->name('protein-types.massDestroy');
    Route::resource('protein-types', 'ProteinTypeController');

    // Upload Form
    Route::delete('upload-forms/destroy', 'UploadFormController@massDestroy')->name('upload-forms.massDestroy');
    Route::post('upload-forms/media', 'UploadFormController@storeMedia')->name('upload-forms.storeMedia');
    Route::post('upload-forms/ckmedia', 'UploadFormController@storeCKEditorImages')->name('upload-forms.storeCKEditorImages');
    Route::resource('upload-forms', 'UploadFormController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});
