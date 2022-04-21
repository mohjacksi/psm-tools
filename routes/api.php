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

    // Person
    Route::apiResource('people', 'PersonApiController');

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

    // Experiment Biological Set
    Route::apiResource('experiment-biological-sets', 'ExperimentBiologicalSetApiController');

    // Biological Set
    Route::apiResource('biological-sets', 'BiologicalSetApiController');

    // Fraction
    Route::apiResource('fractions', 'FractionApiController');

    // Fragment Method
    Route::apiResource('fragment-methods', 'FragmentMethodApiController');

    // Stripe
    Route::apiResource('stripes', 'StripeApiController');

    // Channel
    Route::apiResource('channels', 'ChannelApiController');

    // Channel Psm
    Route::apiResource('channel-psms', 'ChannelPsmApiController');

    // Protein
    Route::post('proteins/media', 'ProteinApiController@storeMedia')->name('proteins.storeMedia');
    Route::apiResource('proteins', 'ProteinApiController');

    // Peptide
    Route::apiResource('peptides', 'PeptideApiController');

    // Peptide Psm
    Route::apiResource('peptide-psms', 'PeptidePsmApiController');

    // Peptide Protein
    Route::apiResource('peptide-proteins', 'PeptideProteinApiController');

    // Tissue
    Route::apiResource('tissues', 'TissueApiController');
});
