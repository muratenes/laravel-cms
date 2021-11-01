<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region\Country;
use App\Models\Region\Neighborhood;
use App\Models\Region\State;

class RegionController extends Controller
{
    /**
     * all countries.
     *
     * @return mixed
     */
    public function countries()
    {
        return Country::cachedAll();
    }

    /**
     * get all states by country.
     *
     * @param int $countryID
     *
     * @return array|mixed
     */
    public function getStatesByCountry(int $countryID)
    {
        return State::getCachedByColumn('country_id', $countryID);
    }

    /**
     * get neighborhood by state.
     *
     * @param int $stateId
     *
     * @return array|mixed
     */
    public function getNeighborhoodByState(int $stateId)
    {
        return Neighborhood::getCachedByColumn('state_id', $stateId);
    }
}
