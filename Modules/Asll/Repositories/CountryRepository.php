<?php

namespace Modules\Asll\Repositories;

use Modules\Asll\Entities\Country;

class CountryRepository
{
    public function getCountries()
    {
        try {
            $countries = Country::select('intID', 'strName')->get();
            return $countries;
        } catch (\Exception $e) {
            return false;
        }
    }
}
