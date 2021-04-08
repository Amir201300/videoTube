<?php

Route::post('/admin/login', 'AuthController@login')->name('admin.login');

Route::prefix('Admin')->group(function () {
    Route::get('/login', function () {
        return view('Admin.loginAdmin');
    });
    Route::group(['middleware' => 'roles', 'roles' => ['Admin']], function () {

        Route::get('/logout/logout', 'AuthController@logout')->name('user.logout');
        Route::get('/home', 'AuthController@index')->name('admin.dashboard');

        // Profile Route
        Route::prefix('profile')->group(function () {
            Route::get('/index', 'profileController@index')->name('profile.index');
            Route::post('/index', 'profileController@update')->name('profile.update');
        });


        // Services Routes
        Route::prefix('Services')->group(function () {
            Route::get('/index', 'ServicesController@index')->name('Services.index');
            Route::get('/allData', 'ServicesController@allData')->name('Services.allData');
            Route::post('/create', 'ServicesController@create')->name('Services.create');
            Route::get('/edit/{id}', 'ServicesController@edit')->name('Services.edit');
            Route::post('/update', 'ServicesController@update')->name('Services.update');
            Route::get('/destroy/{id}', 'ServicesController@destroy')->name('Services.destroy');
        });

        // Goals Routes
        Route::prefix('Goal')->group(function () {
            Route::get('/index', 'GoalsController@index')->name('Goal.index');
            Route::get('/allData', 'GoalsController@allData')->name('Goal.allData');
            Route::post('/create', 'GoalsController@create')->name('Goal.create');
            Route::get('/edit/{id}', 'GoalsController@edit')->name('Goal.edit');
            Route::post('/update', 'GoalsController@update')->name('Goal.update');
            Route::get('/destroy/{id}', 'GoalsController@destroy')->name('Goal.destroy');
        });

        // Audience Routes
        Route::prefix('Audience')->group(function () {
            Route::get('/index', 'AudienceController@index')->name('Audience.index');
            Route::get('/allData', 'AudienceController@allData')->name('Audience.allData');
            Route::post('/create', 'AudienceController@create')->name('Audience.create');
            Route::get('/edit/{id}', 'AudienceController@edit')->name('Audience.edit');
            Route::post('/update', 'AudienceController@update')->name('Audience.update');
            Route::get('/destroy/{id}', 'AudienceController@destroy')->name('Audience.destroy');
        });


        // Admin Routes
        Route::prefix('Admin')->group(function () {
            Route::get('/index', 'AdminController@index')->name('Admin.index');
            Route::get('/allData', 'AdminController@allData')->name('Admin.allData');
            Route::get('/edit/{id}', 'AdminController@edit')->name('Admin.edit');
            Route::post('/create', 'AdminController@create')->name('Admin.create');
            Route::post('/update', 'AdminController@update')->name('Admin.update');
            Route::get('/destroy/{id}', 'AdminController@destroy')->name('Admin.destroy');
        });

        // Admin Routes
        Route::prefix('Specialty')->group(function () {
            Route::get('/index', 'SpecialtyController@index')->name('Specialty.index');
            Route::get('/allData', 'SpecialtyController@allData')->name('Specialty.allData');
            Route::get('/edit/{id}', 'SpecialtyController@edit')->name('Specialty.edit');
            Route::post('/create', 'SpecialtyController@create')->name('Specialty.create');
            Route::post('/update', 'SpecialtyController@update')->name('Specialty.update');
            Route::get('/destroy/{id}', 'SpecialtyController@destroy')->name('Specialty.destroy');
        });

        // VoiceOver Routes
        Route::prefix('VoiceOver')->group(function () {
            Route::get('/index', 'VoiceOverController@index')->name('VoiceOver.index');
            Route::get('/allData', 'VoiceOverController@allData')->name('VoiceOver.allData');
            Route::get('/edit/{id}', 'VoiceOverController@edit')->name('VoiceOver.edit');
            Route::post('/create', 'VoiceOverController@create')->name('VoiceOver.create');
            Route::post('/update', 'VoiceOverController@update')->name('VoiceOver.update');
            Route::get('/destroy/{id}', 'VoiceOverController@destroy')->name('VoiceOver.destroy');
        });

        // Sector Routes
        Route::prefix('Sector')->group(function () {
            Route::get('/index', 'SectorController@index')->name('Sector.index');
            Route::get('/allData', 'SectorController@allData')->name('Sector.allData');
            Route::get('/edit/{id}', 'SectorController@edit')->name('Sector.edit');
            Route::post('/create', 'SectorController@create')->name('Sector.create');
            Route::post('/update', 'SectorController@update')->name('Sector.update');
            Route::get('/destroy/{id}', 'SectorController@destroy')->name('Sector.destroy');
        });

    });
});


