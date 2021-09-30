<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;

class WorkerController extends Controller
{

    public function index(): \Inertia\Response
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('Worker', [
            'data' => [
                'worker_store_link' => route('worker.store'),
                'worker_table_link' => route('worker.table'),
            ],
        ]);
    }

    public function table(): JsonResponse
    {
        return DataTables::of(Worker::all())->make(true);
    }

    public function store(Request $request)
    {
        Worker::updateOrCreate(['id' => $request->has('id') ? $request->id : null],
            [
                'first_name'        => $request->first_name,
                'middle_name'       => $request->middle_name,
                'last_name'         => $request->last_name,
                'birth_date'        => $request->birth_date,
                'gender'            => $request->gender,
                'passport'          => $request->passport,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'iqama'             => $request->iqama,
                'current_address'   => $request->current_address,
                'permanent_address' => $request->permanent_address,
            ]);

        return ['success' => true];
    }
}
