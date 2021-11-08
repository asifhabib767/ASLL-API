<?php

namespace App\Helpers;

use Image;
use File;
// use Illuminate\Http\Request;
use Request;

class DateHelper
{


    public static function ConvertToHoursMins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }
}
