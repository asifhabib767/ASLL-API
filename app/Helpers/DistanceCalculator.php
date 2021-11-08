<?php

namespace App\Helpers;

class DistanceCalculator
{

    /*
    /* lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)
    /*    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees) 
    /*    unit = the unit you desire for results                               
    /*           where: 'mile' is statute miles (default)                        
    /*                  'kilometer' is kilometers                                     
    /*                  'nautical' is nautical miles                                 
    /*                  'meter' is Meter 
    */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "miles") {
                return $miles;
            } else if ($unit == "kilometer") {
                return ($miles * 1.609344);
            } else if ($unit == "nautical") {
                return ($miles * 0.8684);
            } else {
                return ($miles / 0.00062137);
            }
        }
    }
}
