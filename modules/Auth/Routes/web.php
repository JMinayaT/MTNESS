<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes...
$this->get('login', 'LoginController@showLoginForm')->name('login');
$this->post('login', 'LoginController@login');
$this->post('logout', 'LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'ResetPasswordController@reset');




Route::prefix('api')->group(function () {

    
Route::get('auth/permissions.js', function () {
    $permisions = [];
    foreach(Auth::user()->getAllPermissions() as $element) {
        $permisions[] = $element->name;
    }
    $contents = 'window.auth_permissions = ' . json_encode($permisions, config('app.debug', false) ? JSON_PRETTY_PRINT : 0) . ';';
    $response = \Response::make($contents, 200);
    $response->header('Content-Type', 'application/javascript');
    return $response;
})->middleware('auth');

Route::apiResource('user', 'UserController');
Route::apiResource('role', 'RoleController');
Route::get('permission', 'RoleController@indexPermission');

Route::get('roles-permissions/{id}', 'RoleController@getRolesPermissions')->name('roles.get.role-permissions');


});