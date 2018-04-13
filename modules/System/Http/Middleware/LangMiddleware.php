<?php

namespace Modules\System\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\System\Models\Setting;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = '';
        $default_locale = '';
        if(Cache::has('lang_default')) {
            $default_locale = Cache::get('lang_default');
        }
        else {
            $default_locale = Setting::where('key', 'default_lang')->first()->value;
        }
        
        if (! Auth::check() ) {       
            App::setLocale($default_locale);
            return $next($request);
        }
        
        if (Cache::has('lang_user')) {
            $locale = Cache::get('lang_user');       
        }
        else {
            $user = Auth::user();
            if(! $user->hasLang()) {
                $locale = $default_locale;
            }
            else {
                $locale = $user->langName();
            }
            
            Cache::put('lang_user',  $locale, 15);
        }
        App::setLocale($locale);
        return $next($request);
    }
}
