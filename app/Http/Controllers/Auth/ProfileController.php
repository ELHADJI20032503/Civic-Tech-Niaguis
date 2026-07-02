<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function select(Request $request)
    {
        $request->validate([
            'chosen_role' => 'required|string|in:relais,agent',
        ]);

        $role = $request->input('chosen_role');
        session(['active_profile' => $role]);

        return match($role) {
            'relais' => redirect()->route('relais.dashboard'),
            'agent'  => redirect()->route('mairie.dashboard'),
        };
    }
}
