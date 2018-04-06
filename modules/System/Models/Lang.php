<?php

namespace Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    protected $fillable = [
        'code', 'image',
    ];
}
