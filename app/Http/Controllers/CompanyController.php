<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{

    public function index(): \Inertia\Response
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('Company', [
            'data' => [
                'cm_store_link'        => route('company.store'),
                'companies_table_link' => route('company.table'),
            ],
        ]);
    }


    public function table(): JsonResponse
    {
        return DataTables::of(Company::all())->make(true);
    }

    public function store(Request $request): array
    {
        Company::updateOrCreate(
            ["id" => $request->id],
            [
                "name"        => $request->name,
                "description" => $request->description,
                "address"     => $request->address,
                "phone"       => $request->phone,
                "email"       => $request->email,
                "iqama"       => $request->iqama,
                "type"        => $request->type,
            ]);

        return ['success' => true];
    }
}
