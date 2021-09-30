<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\DataTables;

class EmployerController extends Controller
{
    public function index(): \Inertia\Response
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('Employer', [
            'data' => [
                'employer_store_link' => route('employer.store'),
                'employer_table_link' => route('employer.table'),
            ],
        ]);
    }

    public function table(): JsonResponse
    {
        return DataTables::of(Employer::all())->make(true);
    }

    public function store(Request $request)
    {
        Employer::updateOrCreate(['id' => $request->has('id') ? $request->id : null],
            [
                'name'        => $request->name,
                'iqama'       => $request->iqama,
                'phone'       => $request->phone,
                'email'       => $request->email,
                'address'     => $request->address,
                'description' => $request->description,
            ]);

        return ['success' => true];
    }
}
