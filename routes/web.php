<?php

Use \App\Models\Role;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
    //return view('welcome');
});

Route::post('/auth/login', ['uses' => 'Auth\LoginController@login', 'as' => 'auth.login']);
Route::get('/auth/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'auth.logout']);

Route::get('/about', function () {
    $userModel = \App\Models\User::find('1'); //dd($userModel->email);

    $data = [];
    $data['user'] = $userModel;
    return view('about', $data);
});

Route::get('hello', function () {
    //$userModels = \App\Models\User::all();
    $userModel = \App\Models\User::find('1'); dd($userModel->email);
    $testFilter = filter_var('mario.fredrick@tnisiber.id', FILTER_VALIDATE_EMAIL); //dd($testFilter);

    $data = [];
    return view('hello',$data);
})->name('hello');


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', function () {
        return redirect('/aset-jemaat');
    });
});

Route::group(['middleware' => 'auth'], function () {

    Route::match(['get'], 'form-jemaat-induk/search', ['as' => 'form-jemaat-induk.search', 'uses' => 'FormJemaatIndukController@search'])->middleware("minimum_role:" . Role::ROLE_MUPEL);
    Route::match(['get', 'post'], 'form-jemaat-induk/import', ['as' => 'form-jemaat-induk.import', 'uses' => 'FormJemaatIndukController@importJemaatInduk'])->middleware("minimum_role:" . Role::ROLE_MUPEL);
    Route::resource('form-jemaat-induk', 'FormJemaatIndukController');
    


    Route::resource('form-mupel', 'FormMupelController')->middleware("minimum_role:" . Role::ROLE_MUPEL);
    

    
    Route::match(['get'], 'aset-jemaat/export', ['as' => 'aset-jemaat.export', 'uses' => 'AsetJemaatController@exportAset']);
    Route::match(['get', 'post'], 'aset-jemaat/import', ['as' => 'aset-jemaat.import', 'uses' => 'AsetJemaatController@importAset'])->middleware("minimum_role:" . Role::ROLE_ADMIN);
    Route::match(['post'], 'aset-jemaat/add-jenis-aset', ['as' => 'aset-jemaat.add-jenis-aset', 'uses' => 'AsetJemaatController@addJenisAset']);
    Route::match(['post'], 'aset-jemaat/add-status-kelola', ['as' => 'aset-jemaat.add-status-kelola', 'uses' => 'AsetJemaatController@addStatusKelola']);
    Route::match(['post'], 'aset-jemaat/add-keberadaan-dokumen', ['as' => 'aset-jemaat.add-keberadaan-dokumen', 'uses' => 'AsetJemaatController@addKeberadaanDokumen']);
    Route::match(['post'], 'aset-jemaat/add-atas-nama', ['as' => 'aset-jemaat.add-atas-nama', 'uses' => 'AsetJemaatController@addAtasNama']);
    Route::match(['get'], 'aset-jemaat/check-masa-expired-hgb', ['as' => 'aset-jemaat.check-masa-expired-hgb', 'uses' => 'AsetJemaatController@checkMasaExpiredHgb']);
    Route::match(['post'], 'aset-jemaat/stats-by-mupel', ['as' => 'aset-jemaat.stats-by-mupel', 'uses' => 'AsetJemaatController@statsByMupel']);
    Route::match(['get', 'post'], 'aset-jemaat/import/sinode', ['as' => 'aset-jemaat.import.sinode', 'uses' => 'AsetJemaatController@importAsetSinode'])->middleware("minimum_role:" . Role::ROLE_SINODE);
    Route::match(['get'], 'aset-jemaat/list', ['as' => 'aset-jemaat.list', 'uses' => 'AsetJemaatController@listAsetJemaat']);
    Route::match(['get'], 'aset-jemaat/list-aset-tanpa-dokumen', ['as' => 'aset-jemaat.list-aset-tanpa-dokumen', 'uses' => 'AsetJemaatController@listAsetTanpaDokumen']);
    Route::match(['get'], 'aset-jemaat/list-aset-pos-pelkes', ['as' => 'aset-jemaat.list-aset-pos-pelkes', 'uses' => 'AsetJemaatController@listAsetPosPelkes']);
    Route::match(['get'], 'aset-jemaat/list-aset-imb', ['as' => 'aset-jemaat.list-aset-imb', 'uses' => 'AsetJemaatController@listAsetMemilikiIMB']);
    Route::match(['get'], 'aset-jemaat/get-jemaat-by-mupel', ['as' => 'aset-jemaat.get-jemaat-by-mupel', 'uses' => 'AsetJemaatController@getJemaatByMupel']);
    Route::match(['post'], 'aset-jemaat/generate-new-kode-aset', ['as' => 'aset-jemaat.generate-new-kode-aset', 'uses' => 'AsetJemaatController@generateNewKodeAset']);
    Route::resource('aset-jemaat', 'AsetJemaatController');

    Route::resource('jenis-aset', 'JenisAsetController')->middleware("minimum_role:" . Role::ROLE_ADMIN);

    Route::match(['get'], 'users/user-guide-download', ['as' => 'users.user-guide', 'uses' => 'UserController@downloadUserGuide'])->middleware("minimum_role:" . Role::ROLE_JEMAAT);
    Route::match(['get'], 'users/user-guide', ['as' => 'users.user-guide', 'uses' => 'UserController@displayUserGuide'])->middleware("minimum_role:" . Role::ROLE_JEMAAT);
    Route::match(['get', 'post'], 'users/import', ['as' => 'users.import', 'uses' => 'UserController@importUser'])->middleware("minimum_role:" . Role::ROLE_ADMIN);
    Route::match(['get'], 'users/generate-random-password', ['as' => 'users.generate-random-password-form', 'uses' => 'UserController@showGenerateUserRandomPassword'])->middleware("minimum_role:" . Role::ROLE_ADMIN);
    Route::match(['post'], 'users/generate-random-password', ['as' => 'users.generate-random-password', 'uses' => 'UserController@generateUserRandomPassword'])->middleware("minimum_role:" . Role::ROLE_ADMIN);
    Route::match(['get'], 'users/search', ['as' => 'users.search', 'uses' => 'UserController@search'])->middleware("minimum_role:" . Role::ROLE_ADMIN);
    Route::match(['get'], 'users/profile/{id}', ['as' => 'users.profile', 'uses' => 'UserController@profile'])->middleware("minimum_role:" . Role::ROLE_ADMIN);
    Route::match(['get'], 'users/get-mupel-jemaat-by-role', ['uses' => 'UserController@getMupelJematByRole'])->middleware("minimum_role:" . Role::ROLE_ADMIN);
    Route::match(['post'], 'users/profile/{id}', ['as' => 'users.profile', 'uses' => 'UserController@profileStore']);
    Route::match(['get'], 'change/password', ['as' => 'change.password.form', 'uses' => 'UserController@showChangePasswordForm'])->middleware("minimum_role:" . Role::ROLE_JEMAAT);
    Route::match(['post'], 'change/password', ['as' => 'change.password', 'uses' => 'UserController@changePassword'])->middleware("minimum_role:" . Role::ROLE_JEMAAT);
    Route::resource('users', 'UserController')->middleware("minimum_role:" . Role::ROLE_ADMIN);

    // Route::match(['get', 'post'], 'reset/password', ['as' => 'reset.password', 'uses' => 'Auth\ResetPasswordController@showCustomResetForm'])->middleware("minimum_role:" . Role::ROLE_JEMAAT);

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_route

});