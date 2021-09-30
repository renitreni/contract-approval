<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\ContractAudit;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\MyContractStoreRequest;

class MyContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        Inertia::setRootView('layouts/app');

        return Inertia::render('MyContract', [
            'data' => [
                'contract_table_link'    => route('my.contracts.table'),
                'contract_store_link'    => route('my.contracts.store'),
                'contract_overview_link' => route('my.contracts.overview'),
            ],
        ]);
    }

    public function table(User $user)
    {
        return DataTables::of(Contract::query()->where('created_by', auth()->id())->with(['audit']))
            ->setTransformer(function ($data) use ($user) {
                $data = collect($data)->toArray();
                $data["created_at"] = Carbon::parse($data["created_at"])->format("F j, Y");
                $data["updated_at"] = Carbon::parse($data["updated_at"])->format("F j, Y");

                return $data;
            })
            ->make(true);
    }

    public function store(MyContractStoreRequest $request)
    {
        $attr = [];
        foreach ($request->details as $detail) {
            if ($detail['value']) {
                $path = Storage::put('contracts', $detail['value']);
                $attr[] = [
                    "label" => $detail['label'],
                    "name"  => $detail['name'],
                    "value" => $path,
                ];
            }
        }
        $contract = Contract::create([
            'created_by' => auth()->id(),
            'type'       => $request->type,
            'content'    => json_encode($attr),
        ]);

        $custom_id = 'CA'.Carbon::now()->format('ymd');
        $custom_id_2 = Carbon::now()->format('hm');
        $final_id = $custom_id.$contract->id.$custom_id_2;
        Contract::where('id', $contract->id)->update(['custom_id' => $final_id]);

        ContractAudit::create([
            'contract_id' => $contract->id,
            'status'      => 'pending',
            'notes'       => 'Submitted by: '.auth()->user()->name,
        ]);

        Mail::send([], [], function ($message) use ($contract, $final_id) {
            //->cc([auth()->user()->email])
            $message->to(User::getAdminEmails())
                ->from([env('MAIL_USERNAME')])
                ->subject('New Contract For Approval!')
                ->setBody("<h2>Hi Admins,</h2><br> <h3>New Contract No.: {$final_id} has been submitted!</h3>",
                    'text/html');
        });

        return Redirect::route('my.contracts');
    }

    public function overview(Request $request)
    {
        return [
            'other'    => Contract::query()->where('id', $request->id)->first(),
            'contents' => json_decode(Contract::query()->where('id', $request->id)->first()['content'] ?? ''),
        ];
    }
}
