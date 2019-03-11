<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kalem extends Model
{
    protected $guarded = [];

    static function getList($type)
    {
        $list = Kalem::where('kalemTipi', $type)->get();
        return $list;
    }
}
