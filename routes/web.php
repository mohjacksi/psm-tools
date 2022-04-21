<?php

Route::view('/', 'welcome');
Auth::routes(['register' => false]);

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

    // Person
    Route::delete('people/destroy', 'PersonController@massDestroy')->name('people.massDestroy');
    Route::post('people/parse-csv-import', 'PersonController@parseCsvImport')->name('people.parseCsvImport');
    Route::post('people/process-csv-import', 'PersonController@processCsvImport')->name('people.processCsvImport');
    Route::resource('people', 'PersonController');

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
    Route::delete('psms/destroy', 'PsmController@massDestroy')->name('psms.massDestroy');
    Route::post('psms/media', 'PsmController@storeMedia')->name('psms.storeMedia');
    Route::post('psms/ckmedia', 'PsmController@storeCKEditorImages')->name('psms.storeCKEditorImages');
    Route::post('psms/parse-csv-import', 'PsmController@parseCsvImport')->name('psms.parseCsvImport');
    Route::post('psms/process-csv-import', 'PsmController@processCsvImport')->name('psms.processCsvImport');
    Route::resource('psms', 'PsmController');

    // Experiment
    Route::delete('experiments/destroy', 'ExperimentController@massDestroy')->name('experiments.massDestroy');
    Route::post('experiments/media', 'ExperimentController@storeMedia')->name('experiments.storeMedia');
    Route::post('experiments/ckmedia', 'ExperimentController@storeCKEditorImages')->name('experiments.storeCKEditorImages');
    Route::post('experiments/parse-csv-import', 'ExperimentController@parseCsvImport')->name('experiments.parseCsvImport');
    Route::post('experiments/process-csv-import', 'ExperimentController@processCsvImport')->name('experiments.processCsvImport');
    Route::resource('experiments', 'ExperimentController');

    // Experiment Biological Set
    Route::delete('experiment-biological-sets/destroy', 'ExperimentBiologicalSetController@massDestroy')->name('experiment-biological-sets.massDestroy');
    Route::post('experiment-biological-sets/parse-csv-import', 'ExperimentBiologicalSetController@parseCsvImport')->name('experiment-biological-sets.parseCsvImport');
    Route::post('experiment-biological-sets/process-csv-import', 'ExperimentBiologicalSetController@processCsvImport')->name('experiment-biological-sets.processCsvImport');
    Route::resource('experiment-biological-sets', 'ExperimentBiologicalSetController');

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

    // Stripe
    Route::delete('stripes/destroy', 'StripeController@massDestroy')->name('stripes.massDestroy');
    Route::post('stripes/parse-csv-import', 'StripeController@parseCsvImport')->name('stripes.parseCsvImport');
    Route::post('stripes/process-csv-import', 'StripeController@processCsvImport')->name('stripes.processCsvImport');
    Route::resource('stripes', 'StripeController');

    // Channel
    Route::delete('channels/destroy', 'ChannelController@massDestroy')->name('channels.massDestroy');
    Route::post('channels/parse-csv-import', 'ChannelController@parseCsvImport')->name('channels.parseCsvImport');
    Route::post('channels/process-csv-import', 'ChannelController@processCsvImport')->name('channels.processCsvImport');
    Route::resource('channels', 'ChannelController');

    // Channel Psm
    Route::delete('channel-psms/destroy', 'ChannelPsmController@massDestroy')->name('channel-psms.massDestroy');
    Route::post('channel-psms/parse-csv-import', 'ChannelPsmController@parseCsvImport')->name('channel-psms.parseCsvImport');
    Route::post('channel-psms/process-csv-import', 'ChannelPsmController@processCsvImport')->name('channel-psms.processCsvImport');
    Route::resource('channel-psms', 'ChannelPsmController');

    // Protein
    Route::delete('proteins/destroy', 'ProteinController@massDestroy')->name('proteins.massDestroy');
    Route::post('proteins/media', 'ProteinController@storeMedia')->name('proteins.storeMedia');
    Route::post('proteins/ckmedia', 'ProteinController@storeCKEditorImages')->name('proteins.storeCKEditorImages');
    Route::post('proteins/parse-csv-import', 'ProteinController@parseCsvImport')->name('proteins.parseCsvImport');
    Route::post('proteins/process-csv-import', 'ProteinController@processCsvImport')->name('proteins.processCsvImport');
    Route::resource('proteins', 'ProteinController');

    // Peptide
    Route::delete('peptides/destroy', 'PeptideController@massDestroy')->name('peptides.massDestroy');
    Route::post('peptides/parse-csv-import', 'PeptideController@parseCsvImport')->name('peptides.parseCsvImport');
    Route::post('peptides/process-csv-import', 'PeptideController@processCsvImport')->name('peptides.processCsvImport');
    Route::resource('peptides', 'PeptideController');

    // Peptide Psm
    Route::delete('peptide-psms/destroy', 'PeptidePsmController@massDestroy')->name('peptide-psms.massDestroy');
    Route::post('peptide-psms/parse-csv-import', 'PeptidePsmController@parseCsvImport')->name('peptide-psms.parseCsvImport');
    Route::post('peptide-psms/process-csv-import', 'PeptidePsmController@processCsvImport')->name('peptide-psms.processCsvImport');
    Route::resource('peptide-psms', 'PeptidePsmController');

    // Peptide Protein
    Route::delete('peptide-proteins/destroy', 'PeptideProteinController@massDestroy')->name('peptide-proteins.massDestroy');
    Route::post('peptide-proteins/parse-csv-import', 'PeptideProteinController@parseCsvImport')->name('peptide-proteins.parseCsvImport');
    Route::post('peptide-proteins/process-csv-import', 'PeptideProteinController@processCsvImport')->name('peptide-proteins.processCsvImport');
    Route::resource('peptide-proteins', 'PeptideProteinController');

    // Tissue
    Route::delete('tissues/destroy', 'TissueController@massDestroy')->name('tissues.massDestroy');
    Route::post('tissues/parse-csv-import', 'TissueController@parseCsvImport')->name('tissues.parseCsvImport');
    Route::post('tissues/process-csv-import', 'TissueController@processCsvImport')->name('tissues.processCsvImport');
    Route::resource('tissues', 'TissueController');
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
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

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

    // Person
    Route::delete('people/destroy', 'PersonController@massDestroy')->name('people.massDestroy');
    Route::resource('people', 'PersonController');

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
    Route::delete('experiments/destroy', 'ExperimentController@massDestroy')->name('experiments.massDestroy');
    Route::post('experiments/media', 'ExperimentController@storeMedia')->name('experiments.storeMedia');
    Route::post('experiments/ckmedia', 'ExperimentController@storeCKEditorImages')->name('experiments.storeCKEditorImages');
    Route::resource('experiments', 'ExperimentController');

    // Experiment Biological Set
    Route::delete('experiment-biological-sets/destroy', 'ExperimentBiologicalSetController@massDestroy')->name('experiment-biological-sets.massDestroy');
    Route::resource('experiment-biological-sets', 'ExperimentBiologicalSetController');

    // Biological Set
    Route::delete('biological-sets/destroy', 'BiologicalSetController@massDestroy')->name('biological-sets.massDestroy');
    Route::resource('biological-sets', 'BiologicalSetController');

    // Fraction
    Route::delete('fractions/destroy', 'FractionController@massDestroy')->name('fractions.massDestroy');
    Route::resource('fractions', 'FractionController');

    // Fragment Method
    Route::delete('fragment-methods/destroy', 'FragmentMethodController@massDestroy')->name('fragment-methods.massDestroy');
    Route::resource('fragment-methods', 'FragmentMethodController');

    // Stripe
    Route::delete('stripes/destroy', 'StripeController@massDestroy')->name('stripes.massDestroy');
    Route::resource('stripes', 'StripeController');

    // Channel
    Route::delete('channels/destroy', 'ChannelController@massDestroy')->name('channels.massDestroy');
    Route::resource('channels', 'ChannelController');

    // Channel Psm
    Route::delete('channel-psms/destroy', 'ChannelPsmController@massDestroy')->name('channel-psms.massDestroy');
    Route::resource('channel-psms', 'ChannelPsmController');

    // Protein
    Route::delete('proteins/destroy', 'ProteinController@massDestroy')->name('proteins.massDestroy');
    Route::post('proteins/media', 'ProteinController@storeMedia')->name('proteins.storeMedia');
    Route::post('proteins/ckmedia', 'ProteinController@storeCKEditorImages')->name('proteins.storeCKEditorImages');
    Route::resource('proteins', 'ProteinController');

    // Peptide
    Route::delete('peptides/destroy', 'PeptideController@massDestroy')->name('peptides.massDestroy');
    Route::resource('peptides', 'PeptideController');

    // Peptide Psm
    Route::delete('peptide-psms/destroy', 'PeptidePsmController@massDestroy')->name('peptide-psms.massDestroy');
    Route::resource('peptide-psms', 'PeptidePsmController');

    // Peptide Protein
    Route::delete('peptide-proteins/destroy', 'PeptideProteinController@massDestroy')->name('peptide-proteins.massDestroy');
    Route::resource('peptide-proteins', 'PeptideProteinController');

    // Tissue
    Route::delete('tissues/destroy', 'TissueController@massDestroy')->name('tissues.massDestroy');
    Route::resource('tissues', 'TissueController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});
