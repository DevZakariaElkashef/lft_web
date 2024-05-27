<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentCarTranfer;
use App\Models\Car;
use Illuminate\Http\Request;

class AgentCarTranferController extends Controller
{
    public function index($id)
    {
        $agent = Agent::findOrFail($id);

        $items = $agent->agentCarTransfers;

        return view('admin.agents_car_tranfer.index', compact('agent', 'items'));
    }


    public function create($id)
    {
        $agent = Agent::findOrFail($id);

        $cars = Car::all();

        return view('admin.agents_car_tranfer.create', compact('agent', 'cars'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'agent_id' =>'required|exists:agents,id',
            'car_id' =>'required|exists:cars,id',
            'name' =>'required|string|max:255',
            'value' =>'required|numeric'
        ]);

        $data['user_id'] = auth()->user()->id;

        $agent = Agent::find($data['agent_id']);

        $car = Car::findOrFail($data['car_id']);

        $agentwallet = $agent->wallet;

        if($request->value > $agentwallet) {
            return redirect()->back()->with('error', __('main.you dont have enougth money'));
        }

        $agent->update(['wallet'=> $agentwallet - $request->value]);
        $car->update(['wallet'=> $car->wallet + $request->value]);

        $agent->agentCarTransfers()->create($data);

        return redirect()->route('agent_car_tranfer.index', $agent->id)->with('success', __('alerts.added_successfully'));
    }

    public function edit($id)
    {
        $item = AgentCarTranfer::findOrFail($id);

        $cars = Car::all();

        return view('admin.agents_car_tranfer.edit', compact('cars', 'item'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'car_id' =>'required|exists:cars,id',
            'name' =>'required|string|max:255',
            'value' =>'required|numeric'
        ]);

        $item = AgentCarTranfer::findOrFail($id);

        $oldValue = $item->value;
        $newValue = $request->value;
        $agent = $item->agent;


        if ($oldValue > $newValue) {
            $diff = $oldValue - $newValue;
            $agent->update(['wallet' => $agent->wallet + $diff]);
        }

        if ($newValue > $oldValue) {
            $diff = $newValue - $oldValue;

            if ($agent->wallet - $diff < 0) {
                return redirect()->back()->with('error', __('main.you dont have enougth money'));
            }

            $agent->update(['wallet' => $agent->wallet - $diff]);
        }

        $item->update($data);


        return redirect()->route('agent_car_tranfer.index', $agent->id)->with('success', __('alerts.updated_successfully'));
    }

    public function destroy($id)
    {
        $item = AgentCarTranfer::findOrFail($id);

        $item->delete();

        return response()->json(['staus' => true, 'msg' => __('alerts.deleted_successfully')], 200);
    }
}
