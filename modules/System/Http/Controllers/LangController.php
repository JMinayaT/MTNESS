<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\System\Models\Lang;
use Modules\System\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\System\Http\Resources\LangResource;

class LangController extends Controller
{

    /**
     * construct method.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $this->authorize('read', Lang::class);
       return LangResource::collection(Lang::all());
    }

    

    /**
     * Get current user lang.
     *
     * @return string
    */
    public function getUserLang()
    {
        $this->authorize('readUser', Lang::class);
        $user = Auth::user();
        $name = $user->langName();
        if($name == false){
            return '';
        }
        return $name;
    }

    /**
     * Get current default lang.
     *
     * @return string
    */
    public function getDefaultLang()
    {
        $this->authorize('readDefault', Lang::class);
        $lang = Setting::where('key', 'default_lang')->first();
        return $lang->value;
    }

    /**
     * update current user lang.
     *
     * @return void
    */
    public function updateUserLang(Request $request)
    {
        $this->authorize('readUser', Lang::class);
        $user = Auth::user();
        $user->setLang($request['id']);
        Cache::forget('lang_user');
        Cache::put('lang_user',$request['code'], 15);
    }

    /**
     * update current default lang.
     *
     * @return void
    */
    public function updateDefaultLang(Request $request)
    {
        $this->authorize('readDefault', Lang::class);
        $lang = Setting::where('key', 'default_lang')->first();
        $lang->value = $request['lang'];
        $lang->save();
        Cache::forget('lang_default');
        Cache::put('lang_default',$request['lang'], 15);
    }
}
