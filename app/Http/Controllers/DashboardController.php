<?php

namespace App\Http\Controllers;

use App\Models\OfficialCase;
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
                'search_contract' => route('search.contract'),
                'search_cases'    => route('search.case'),
            ],
        ]);
    }

    public function searchContract(Request $request)
    {
        return Contract::where('custom_id', $request->keyword)->with(['creator', 'audit'])->first();
    }

    public function searchCase(Request $request)
    {
        $results = OfficialCase::query()
            ->when($request->drop_down == 'Company', function ($q) use ($request) {
                $q->whereHas('company', function ($query) use ($request) {
                    $q = strtolower($request->keyword);
                    $query->whereRaw("lower(name) like '%{$q}%'");
                });
            })->when($request->drop_down == 'Employer', function ($q) use ($request) {
                $q->whereHas('employer', function ($query) use ($request) {
                    $q = strtolower($request->keyword);
                    $query->whereRaw("lower(name) like '%{$q}%'");
                });
            })->when($request->drop_down == 'Worker', function ($q) use ($request) {
                $q->whereHas('employer', function ($query) use ($request) {
                    $q = strtolower($request->keyword);
                    $query->where('lower(`last_name`)', 'like', "%{$q}%")
                        ->orWhere('lower(first_name)', 'like', "%{$q}%")
                        ->orWhere('lower(middle_name)', 'like', "%{$q}%");
                });
            });

        return $results->get()->toArray();
    }

    public function searchCompany(Request $request)
    {
        return OfficialCase::query()
            ->select('status')
            ->where("company_id", $request->company_id)
            ->where("status", 'suspended')->first();
    }
}
