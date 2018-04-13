<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/


//LANG
Route::get('js/{module}/lang-{locale}.js', function ($module, $locale) {
    // Add locale to the cache key
    $json = \Cache::rememberForever("{$module}-lang-{$locale}.js", function () use ($locale,$module) {
        $lang = config('app.locale');

        $files   = glob(base_path('modules/'.$module.'/Resources/lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    $contents = 'window.i18n = ' . json_encode($json, config('app.debug', false) ? JSON_PRETTY_PRINT : 0) . ';';
    $response = \Response::make($contents, 200);
    $response->header('Content-Type', 'application/javascript');

    return $response;
});

//<script src="/js/module/lang-{{ \App::getLocale() }}.js"></script>