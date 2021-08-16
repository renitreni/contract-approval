<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Contract;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('Dashboard', [
            'data' => [
                'search_contract' => route('search.contract')
            ],
        ]);
    }

    public function searchContract(Request $request)
    {
        return Contract::where('custom_id', $request->keyword)->with(['creator', 'audit'])->first();
    }
}
