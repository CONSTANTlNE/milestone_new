<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::where('status', 1)
            ->orderBy('position', 'asc')
            ->paginate(50);
        return view('frontend.teams.index', compact('teams'));
    }

    public function show($lang, $id)
    {
        $team = Team::findOrFail($id);
        return view('frontend.teams.show', compact('team'));
    }
}
