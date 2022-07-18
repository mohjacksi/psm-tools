<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController', ['except' => ['destroy']]);

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Project
    Route::post('projects/media', 'ProjectApiController@storeMedia')->name('projects.storeMedia');
    Route::apiResource('projects', 'ProjectApiController');

    // Sample
    Route::post('samples/media', 'SampleApiController@storeMedia')->name('samples.storeMedia');
    Route::apiResource('samples', 'SampleApiController');

    // Dna Region
    Route::apiResource('dna-regions', 'DnaRegionApiController');

    // Transcript
    Route::apiResource('transcripts', 'TranscriptApiController');

    // Psm
    Route::post('psms/media', 'PsmApiController@storeMedia')->name('psms.storeMedia');
    Route::apiResource('psms', 'PsmApiController');

    // Experiment
    Route::post('experiments/media', 'ExperimentApiController@storeMedia')->name('experiments.storeMedia');
    Route::apiResource('experiments', 'ExperimentApiController');

    // Biological Set
    Route::apiResource('biological-sets', 'BiologicalSetApiController');

    // Fraction
    Route::apiResource('fractions', 'FractionApiController');

    // Fragment Method
    Route::apiResource('fragment-methods', 'FragmentMethodApiController');

    // Strip
    Route::apiResource('strips', 'StripApiController');

    // Channel
    Route::apiResource('channels', 'ChannelApiController');

    // Protein
    Route::post('proteins/media', 'ProteinApiController@storeMedia')->name('proteins.storeMedia');
    Route::apiResource('proteins', 'ProteinApiController');

    // Peptide
    Route::apiResource('peptides', 'PeptideApiController');

    // Tissue
    Route::apiResource('tissues', 'TissueApiController');

    // Peptide With Modification
    Route::apiResource('peptide-with-modifications', 'PeptideWithModificationApiController');

    // Peptid Category
    Route::apiResource('peptid-categories', 'PeptidCategoryApiController');

    // Protein Type
    Route::apiResource('protein-types', 'ProteinTypeApiController');
});
