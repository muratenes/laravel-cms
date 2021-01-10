<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\OurTeamInterface;
use Illuminate\Http\Request;

class TakimimizController extends Controller
{
    private OurTeamInterface $_teamService;

    public function __construct(OurTeamInterface $teamService)
    {
        $this->_teamService = $teamService;
    }

    public function list()
    {
        $list = $this->_teamService->all(['active' => 1]);
        return view('site.ourTeam.ourTeam', compact('list'));
    }
}
