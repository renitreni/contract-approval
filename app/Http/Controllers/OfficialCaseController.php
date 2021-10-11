<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficialCaseRequest;
use App\Mail\CaseNotifierMail;
use App\Models\OfficialCase;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
                'case_notify_link'    => route('cases.notify'),
            ],
        ]);
    }

    public function table(): JsonResponse
    {
        return DataTables::of(OfficialCase::all())->setTransformer(function ($value) {
            $data = collect($value)->toArray();
            $worker = $data['worker'];

            $data['suspension_date_display'] = Carbon::parse($data['suspension_date'])->format('F j, Y');
            $data['company_name_display'] = "<button class='btn btn-sm btn-info text-white btn-notifier'><i class='fas fa-envelope'></i></button> {$data['company']['name']}";
            $data['full_name'] = $worker['last_name'].", ".$worker['first_name']." ".$worker['middle_name'];
            $data['status_btn'] = '<button class="btn btn-sm bg-success position-relative btn-name text-white" type="button">Lifted</button>';

            if ($data['status'] == 'suspended') {
                $data['status_btn'] = "<button class='btn btn-sm bg-danger position-relative btn-name text-white' type='button'>Suspended <span class=\"badge bg-secondary\">{$data['days_suspended']}</span></button>";
            }
            if ($data['status'] == 'warning') {
                $data['status_btn'] = "<button class=\"btn btn-sm bg-warning position-relative btn-name\" type=\"button\">Warning <span class=\"badge bg-secondary\">{$data['days_warning']}</span></button>";
            }

            return $data;
        })->make(true);
    }

    public function store(OfficialCaseRequest $request)
    {
        OfficialCase::updateOrCreate(['id' => $request->has('id') ? $request->id : null],
            [
                'status'          => $request->status,
                'company_id'      => $request->company_id,
                'worker_id'       => $request->worker_id,
                'employer_id'     => $request->employer_id,
                'suspension_date' => $request->suspension_date,
                'lifted_date'     => $request->lifted_date,
                'days_suspended'  => $request->days_suspended,
                'days_warning'    => $request->days_warning,
                'case_officer'    => $request->case_officer,
                'atnsia_no'       => $request->atnsia_no,
                'complaint_id'    => $request->complaint_id,
                'complaint'       => $request->complaint,
                'remarks'         => $request->remarks,
            ]);

        return ['success' => true];
    }

    public function sendNotification(Request $request)
    {
        Mail::to([$request->company['email']])->bcc([config('mail.from.address')])->send(new CaseNotifierMail($request));

        return ['success' => true];
    }
}
