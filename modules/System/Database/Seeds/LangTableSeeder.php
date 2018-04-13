<?php
namespace Modules\System\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\System\Models\Lang;
use Modules\System\Models\Setting;

class LangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //EN -- English
        Lang::create([
            'code' => 'en',
            'image' => '/images/lang/en.png',
        ]);
        
        //ES -- Spanish
        Lang::create([
            'code' => 'es',
            'image' => '/images/lang/es.png',
        ]); 

        //Default lang
        Setting::create([
            'key' => 'default_lang',
            'value' => 'en',
        ]); 


    }
}