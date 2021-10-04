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
                'cases_store_link'    => route('cases.store'),
                'cases_table_link'    => route('cases.table'),
                'list_agencies_link'  => route('list.agencies'),
                'list_employers_link' => route('list.employers'),
                'list_workers_link'   => route('list.workers'),
            ],
        ]);
    }

    public function table(): JsonResponse
    {
        return DataTables::of(OfficialCase::all())->setTransformer(function ($value) {
            $data = collect($value)->toArray();
            $data['suspension_date_display'] = Carbon::parse($data['suspension_date'])->format('F j, Y');
            $worker = $data['worker'];
            $data['full_name'] = $worker['last_name'].", ".$worker['first_name']." ".$worker['middle_name'];

            $data['status_btn'] = "<a href='#' class='btn-name'>
                                     <span class='badge bg-success'>Lifted</span>
                                   </a>";
            if ($data['status'] == 'suspended') {
                $data['status_btn'] = "<a href='#' class='btn-name'>
                                        <span class='badge bg-danger text-2xl'>Suspended</span>
                                       </a>";
            }
            if ($data['status'] == 'warning') {
                $data['status_btn'] = "<a href='#' class='btn-name'>
                                        <span class='badge bg-warning text-2xl'>Warning</span>
                                       </a>";
            }
            return $data;
        })->make(true);
    }

    public function store(Request $request)
    {
        OfficialCase::updateOrCreate(['id' => $request->has('id') ? $request->id : null],
            [
                'status'          => $request->status,
                'company_id'      => $request->company_id,
                'suspension_date' => $request->suspension_date,
                'lifted_date'     => $request->lifted_date,
                'days_suspended'  => $request->days_suspended,
                'employer_id'     => $request->employer_id,
                'case_officer'    => $request->case_officer,
                'worker_id'       => $request->worker_id,
                'atnsia_no'       => $request->atnsia_no,
                'complaint_id'    => $request->complaint_id,
                'complaint'       => $request->complaint,
                'remarks'         => $request->remarks,
            ]);

        return ['success' => true];
    }
}
