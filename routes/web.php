<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Project
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::resource('projects', 'ProjectController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Person
    Route::delete('people/destroy', 'PersonController@massDestroy')->name('people.massDestroy');
    Route::resource('people', 'PersonController');

    // Sample
    Route::delete('samples/destroy', 'SampleController@massDestroy')->name('samples.massDestroy');
    Route::resource('samples', 'SampleController');

    // Dna Region
    Route::delete('dna-regions/destroy', 'DnaRegionController@massDestroy')->name('dna-regions.massDestroy');
    Route::resource('dna-regions', 'DnaRegionController');

    // Transcript
    Route::delete('transcripts/destroy', 'TranscriptController@massDestroy')->name('transcripts.massDestroy');
    Route::resource('transcripts', 'TranscriptController');

    // Proteins
    Route::delete('proteins/destroy', 'ProteinsController@massDestroy')->name('proteins.massDestroy');
    Route::resource('proteins', 'ProteinsController');

    // Peptides
    Route::delete('peptides/destroy', 'PeptidesController@massDestroy')->name('peptides.massDestroy');
    Route::resource('peptides', 'PeptidesController');

    // Psms
    Route::delete('psms/destroy', 'PsmsController@massDestroy')->name('psms.massDestroy');
    Route::resource('psms', 'PsmsController');
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
