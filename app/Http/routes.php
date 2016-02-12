<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

    Route::get('/sig/new', ['uses' => 'SignatureController@index', 'as' => 'sig.new']);
    Route::post('/sig/create', ['uses' => 'SignatureController@create', 'as' => 'sig.create']);

    Route::get('/sheets', ['uses' => 'SheetController@index', 'as' => 'sheets.all']);
    Route::get('/sheets/{id}', ['uses' => 'SheetController@single', 'as' => 'sheets.single']);

    Route::post('/sheets/bm/{id}', ['uses' => 'SheetController@addBookmarker', 'as' => 'sheets.add_bookmarker']);
    Route::post('/sheets/es/{id}', ['uses' => 'SheetController@addEscalator', 'as' => 'sheets.add_escalator']);
    Route::post('/sheets/finished/{id}', ['uses' => 'SheetController@markAsFinished', 'as' => 'sheets.mark_as_finished']);
    Route::post('/sheets/{id}/pay/{pilot_id}', ['uses' => 'SheetController@payPilot', 'as' => 'sheets.pay_pilot']);
    Route::post('/sheets/{id}/add', ['uses' => 'SheetController@addPilots', 'as' => 'sheets.add_pilots']);
    Route::post('/sheets/{id}/remove/{pilot_id}', ['uses' => 'SheetController@removePilot', 'as' => 'sheets.remove_pilot']);
    Route::post('/sheets/pay/{id}', ['uses' => 'SheetController@markAsPaid', 'as' => 'sheets.mark_as_paid']);
    Route::post('/sheets/defanger/{id}', ['uses' => 'SheetController@addDefanger', 'as' => 'sheets.add_defanger']);


    Route::get('/options', ['uses' => 'OptionsController@index', 'as' => 'options.all']);
    Route::post('/options/{id}', ['uses' => 'OptionsController@action', 'as' => 'options.action']);

});
