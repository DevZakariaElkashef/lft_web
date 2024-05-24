<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MoneyTransferRequest;
use App\Models\AppNotification;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Imports\ServiceImport;
use App\Models\Agent;
use App\Models\Company;
use App\Models\MoneyTransfer;
use App\Services\SaveNotification;
use App\Services\SendNotification;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MoneyTransferController extends Controller
{

    public function index()
    {
        $input = [
            'financial_custody_agents'     => MoneyTransfer::all(),
            'route_create'      => route('financial_custody_agents.create')
        ];

        return view('admin.financial_custody_agents.index', $input);
    }

    public function create()
    {
        $input = [
            'agents'         => Agent::pluck('name', 'id'),
            'method'            => 'POST',
            'action'            => route('financial_custody_agents.store'),
        ];


        return view('admin.financial_custody_agents.create', $input);
    }

    public function store(MoneyTransferRequest $request)
    {

        $agent = Agent::find($request->agent_id);

        $data["value"] = $request->value;
        $data["transfered_type"] = "App\Models\Agent";
        $data["transfered_id"] = $request->agent_id;
        $data["transferer_type"] = "App\Models\User";
        $data["transferer_id"] = auth()->id();
        $data["type"] = 1;
        $moneyTransfer =MoneyTransfer::create($data);

        $value = $request->value;

        $title = "new Notification";
        $text ="A daily financial custody with a value $value has been added to the agent $agent->name";

        SaveNotification::create($title, $text, $agent->id, Agent::class,AppNotification::specific);
        SendNotification::send($agent->device_token ?? "", $title, $text);

        return redirect()->route('financial_custody_agents.index')->with(['success' => __('alerts.added_successfully')]);
    }

    public function destroy($id)
    {
        $MoneyTransfer = MoneyTransfer::find($id);
        $MoneyTransfer->delete();
        return response()->json(['staus' => true, 'msg' => __('alerts.deleted_successfully')], 200);
    }

}
