<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    protected $guarded = [];

    static function Insert($text, $islem)
    {
        Logger::create(['text' => $text, 'islem' => $islem]);
    }
}
