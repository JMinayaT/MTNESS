<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/


//LANG
Route::get('js/lang-{locale}.js', function ($locale) {
    // Add locale to the cache key
    $json = \Cache::rememberForever("lang-{$locale}.js", function () use ($locale) {
        $allFiles = [];
        foreach(Module::allName() as $module){
            $allFiles[] = glob(base_path('modules/'.$module.'/Resources/lang/' . $locale . '/*.php'));
        }
        //$files   = glob(base_path('modules/'.$module.'/Resources/lang/' . $locale . '/*.php'));
        $strings = [];

        foreach ($allFiles as $files) {
            foreach ($files as $file) {
                $name           = basename($file, '.php');
                $strings[$name] = require $file;
            }
        }
        return $strings;
    });

    $contents = 'window.i18n = ' . json_encode($json, config('app.debug', false) ? JSON_PRETTY_PRINT : 0) . ';';
    $response = \Response::make($contents, 200);
    $response->header('Content-Type', 'application/javascript');

    return $response;
});

//<script src="/js/module/lang-{{ \App::getLocale() }}.js"></script>


Route::middleware(['auth'])->group(function () {
    Route::prefix('api')->group(function () {
        Route::get('lang', 'LangController@index')->name('lang');
        Route::get('default-lang', 'LangController@getDefaultLang')->name('lang.default');
        Route::post('default-lang', 'LangController@updateDefaultLang')->name('lang.default.update');
        Route::get('user-lang', 'LangController@getUserLang')->name('lang.user.get');
        Route::post('user-lang', 'LangController@updateUserLang')->name('lang.user.update');
    });
});
