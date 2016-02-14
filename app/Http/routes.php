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
    Route::get('/login', ['uses' => 'AuthController@login', 'as' => 'auth.login']);
    Route::get('/auth/sso', ['uses' => 'AuthController@callback', 'as' => 'auth.callback']);
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/sig/new', ['uses' => 'SignatureController@index', 'as' => 'sig.new']);
    Route::post('/sig/create', ['uses' => 'SignatureController@create', 'as' => 'sig.create']);

    Route::get('/sheets', ['uses' => 'SheetController@index', 'as' => 'sheets.all']);
    Route::get('/sheets/{id}', ['uses' => 'SheetController@single', 'as' => 'sheets.single']);

    Route::post('/sheets/bm/{id}', ['uses' => 'SheetController@addBookmarker', 'as' => 'sheets.add_bookmarker']);
    Route::post('/sheets/es/{id}', ['uses' => 'SheetController@addEscalator', 'as' => 'sheets.add_escalator']);
    Route::post('/sheets/finished/{id}', ['uses' => 'SheetController@markAsFinished', 'as' => 'sheets.mark_as_finished']);
    Route::post('/sheets/{id}/pay/{pilot_id}', ['uses' => 'SheetController@payPilot', 'as' => 'sheets.pay_pilot']);
    Route::post('/sheets/{id}/add', ['uses' => 'SheetController@addPilots', 'as' => 'sheets.add_pilots']);
    Route::post('/sheets/{id}/close', ['uses' => 'SheetController@close', 'as' => 'sheets.close']);
    Route::post('/sheets/{id}/remove/{pilot_id}', ['uses' => 'SheetController@removePilot', 'as' => 'sheets.remove_pilot']);
    Route::post('/sheets/pay/{id}', ['uses' => 'SheetController@markAsPaid', 'as' => 'sheets.mark_as_paid']);
    Route::post('/sheets/defanger/{id}', ['uses' => 'SheetController@addDefanger', 'as' => 'sheets.add_defanger']);

    Route::get('/stats', ['uses' => 'StatsController@index', 'as' => 'stats.all']);

    Route::get('/logout', ['uses' => 'AuthController@logout', 'as' => 'auth.logout']);
});

Route::group(['middleware' => ['web', 'admin']], function () {
    Route::get('/admin', ['uses' => 'AdminController@index', 'as' => 'admin.index']);
    Route::post('/admin/api/users', ['uses' => 'AdminController@ajaxUsers', 'as' => 'admin.api_users']);
    Route::get('/admin/user/info/{id}', ['uses' => 'AdminController@userInfo', 'as' => 'admin.user_info']);
    Route::post('/admin/user/promote/{id}', ['uses' => 'AdminController@promoteUser', 'as' => 'admin.promote_user']);
    Route::post('/admin/user/demote/{id}', ['uses' => 'AdminController@demoteUser', 'as' => 'admin.demote_user']);

    Route::get('/options', ['uses' => 'OptionsController@index', 'as' => 'options.all']);
    Route::post('/options/{id}', ['uses' => 'OptionsController@action', 'as' => 'options.action']);
});