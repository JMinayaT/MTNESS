<?php
namespace Modules\System\Http\Traits;

trait HasLang
{
     
    /**
     * The roles that belong to the user.
     */
    public function lang()
    {
        return $this->belongsToMany('Modules\Langs\Models\Lang');
    }

    public function langName()
    {
        if (! $this->hasLang()){
            return false;
        }
        return $this->langToArray()[0]['code'];
    }

    public function setLang($id)
    {
        $this->lang()->sync($id);
    }

    public function hasLang()
    {
        if (empty($this->langToArray())){
            return false;
        }
        return true;   
    }

    protected function langToArray()
    {
       return $this->lang->toArray();
    }
}

//update
//$user->lang()->sync(1)

//add
//$user->lang()->attach('1');
