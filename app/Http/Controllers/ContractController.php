<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\User;
use Inertia\Response;
use App\Models\Contract;
use Silber\Bouncer\Bouncer;
use Illuminate\Http\Request;
use App\Models\ContractAudit;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ContractController extends Controller
{
    public function index()
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('Contracts', [
            'data' => [
                'contract_pending_table_link' => route('contracts.table.pending'),
                'contract_overview_link'      => route('my.contracts.overview'),
                'contracts_approval'          => route('contracts.approval'),
            ],
        ]);
    }

    public function indexApproved()
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('ContractsApproved', [
            'data' => [
                'contract_approved_table_link' => route('contracts.table.approved'),
                'contract_overview_link'       => route('my.contracts.overview'),
                'contracts_approval'           => route('contracts.approval'),
            ],
        ]);
    }

    public function pendingTable()
    {
        return DataTables::of(Contract::fetchPending())->setTransformer(function ($data) {
            $data               = collect($data)->toArray();
            $data["created_at"] = Carbon::parse($data["created_at"])->format("F j, Y h:i:sA");
            $data["updated_at"] = Carbon::parse($data["updated_at"])->format("F j, Y h:i:sA");

            return $data;
        })->make(true);
    }

    public function approvedTable()
    {
        return DataTables::of(Contract::fetchApproved())->setTransformer(function ($data) {
            $data               = collect($data)->toArray();
            $data["created_at"] = Carbon::parse($data["created_at"])->format("F j, Y h:i:sA");
            $data["updated_at"] = Carbon::parse($data["updated_at"])->format("F j, Y h:i:sA");

            return $data;
        })->make(true);
    }

    public function approveContract(Request $request, Bouncer $bouncer)
    {
        ContractAudit::where('contract_id', $request->id)
                     ->where('status', 'pending')
                     ->update([
                         'status' => 'reviewed',
                     ]);

        ContractAudit::create([
            'contract_id' => $request->id,
            'status'      => 'approved',
            'notes'       => 'Contract has been approved by: ' . auth()->user()->name,
            'audited_by'  => auth()->id(),
        ]);

        $contract = Contract::where('contracts.id', $request->id)
                            ->selectRaw('custom_id, u.email, u.name')
                            ->join('users as u', 'u.id', '=', 'contracts.created_by')
                            ->first();

        Mail::send([], [], function ($message) use ($contract) {
            $message->to([$contract->email])
                    ->from([env('MAIL_USERNAME')])
                    ->cc(User::getAdminEmails())
                    ->subject('Your submitted Contract has been approved!')
                    ->setBody("<h2>Hi {$contract->name},</h2><br> <h3>Contract No.: {$contract->custom_id}</h3>",
                        'text/html');
        });

        return ['success' => true];
    }
}
