<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ShipmentExport;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ShipmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:shipments.index')->only('index');
        $this->middleware('permission:shipments.create')->only(['create', 'store']);
        $this->middleware('permission:shipments.udpate')->only(['edit', 'udpate']);
        $this->middleware('permission:shipments.delete')->only('destroy');
    }
    public function index(Request $request, $id)
    {
        $car = Car::findOrfail($id);
        $shipments = Shipment::query();

        if ($request->filled('date_from')) {
            $shipments->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $shipments->whereDate('date', '<=', $request->date_to);
        }

        $shipments = $shipments->where('car_id', $id)->get();

        return view('admin.shipments.index', compact('car', 'shipments'));
    }

    public function export(Request $request, $id)
    {

        $ids = explode(',', $request->ids);
        return Excel::download(new ShipmentExport($ids), 'shipments.xlsx');
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
            'addition' => 'nullable|numeric'
        ]);
        $data['user_id'] = auth()->user()->id;

        $car = Car::findOrFail($request->car_id);
        $value = $request->value + $request->addition;
        if ($car->wallet >= $value) {
            $car->update([
                'wallet' => $car->wallet - $value
            ]);

            Shipment::create($data);

            return to_route('shipments.index', $request->car_id)->with('success', __('alerts.added_successfully'));
        }

        return to_route('shipments.index', $request->car_id)->with('error', __('main.car_wallet_does_not_have_enough_amount'));
    }

    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'date' => 'required|date',
            'addition' => 'nullable|numeric'
        ]);
        $data['user_id'] = auth()->user()->id;


        $oldValue = $shipment->value + $shipment->addition;
        $newValue = $request->value + $request->addition;
        $car = $shipment->car;

        if ($newValue > $oldValue) {
            $diff = $newValue - $oldValue;

            if ($car->wallet - $diff < 0) {
                return to_route('shipments.index', $car->id)->with('error', __('main.car_wallet_does_not_have_enough_amount'));
            }

            $car->update([
                'wallet' => $car->wallet - $diff
            ]);
        }

        if ($oldValue > $newValue) {
            $diff = $oldValue - $newValue;
            $car->update([
                'wallet' => $car->wallet + $diff
            ]);
        }

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
