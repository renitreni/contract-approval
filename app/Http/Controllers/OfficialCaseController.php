<?php

namespace App\Http\Controllers;

use App\Models\OfficialCase;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\DataTables;

class OfficialCaseController extends Controller
{

    public function index(): \Inertia\Response
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('Cases', [
            'data' => [
                'cases_store_link' => route('cases.store'),
                'cases_table_link' => route('cases.table'),
            ],
        ]);
    }

    public function table(): JsonResponse
    {
        return DataTables::of(OfficialCase::all())->setTransformer(function ($value) {
            $data = collect($value)->toArray();
            $data['suspension_date'] = Carbon::parse($data['suspension_date'])->format('F j, Y');
            $data['full_name'] = $data['worker']['last_name'].", ".$data['worker']['first_name']." ".$data['worker']['middle_name'];

            return $data;
        })->make(true);
    }

    public function store(Request $request)
    {
//        Employer::updateOrCreate(['id' => $request->has('id') ? $request->id : null],
//            [
//                'name'        => $request->name,
//                'iqama'       => $request->iqama,
//                'phone'       => $request->phone,
//                'email'       => $request->email,
//                'address'     => $request->address,
//                'description' => $request->description,
//            ]);

        return ['success' => true];
    }
}
