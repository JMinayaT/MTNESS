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