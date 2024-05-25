<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index($id)
    {
        $car = Car::findOrfail($id);
        $shipments = $car->shipments;

        return view('admin.shipments.index', compact('car', 'shipments'));
    }

    public function create($id)
    {
        $car = Car::findOrfail($id);
        

        return view('admin.shipments.create', compact('car'));
    }
   
   
    public function edit($id)
    {
        $shipment = Shipment::findOrfail($id);

        return view('admin.shipments.edit', compact('shipment'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'date' => 'required|date',
            'additions' => 'nullable|numeric'
        ]);

        Shipment::create($data);

        return to_route('shipments.index', $request->car_id)->with('success', __('alerts.added_successfully'));
    }

    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'date' => 'required|date',
            'additions' => 'nullable|numeric'
        ]);

        $shipment->update($data);

        return to_route('shipments.index', $shipment->car_id)->with('success', __('alerts.updated_successfully'));
    }


    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);

        $shipment->delete();

        return response()->json(['staus' => true, 'msg' => __('alerts.deleted_successfully')], 200);
    }
}
