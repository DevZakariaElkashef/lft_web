<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\BankTrnsaction;
use App\Http\Traits\ImagesTrait;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BankTransactionExport;

class BankTransactionController extends Controller
{
    use ImagesTrait;
    
    public function __construct()
    {
        $this->middleware('permission:bank.index')->only('index');
        $this->middleware('permission:bank.create')->only(['create', 'store']);
        $this->middleware('permission:bank.udpate')->only(['edit', 'udpate']);
        $this->middleware('permission:bank.delete')->only('destroy');
    }
    public function index(Request $request, $id)
    {
        $bank = Bank::findOrfail($id);
        $banktransactions = BankTrnsaction::query();

        if ($request->filled('date_from')) {
            $banktransactions->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $banktransactions->whereDate('created_at', '<=', $request->date_to);
        }

        $banktransactions = $banktransactions->where('bank_id', $id)->get();

        return view('admin.banktransactions.index', compact('bank', 'banktransactions'));
    }

    public function export(Request $request, $id)
    {

        $ids = explode(',', $request->ids);
        return Excel::download(new BankTransactionExport($ids), 'transactions.xlsx');
    }

    public function create($id)
    {
        $bank = Bank::findOrfail($id);

        return view('admin.banktransactions.create', compact('bank'));
    }


    public function edit($id)
    {
        $item = BankTrnsaction::findOrfail($id);

        return view('admin.banktransactions.edit', compact('item'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:0,1',
            'image' => 'nullable|mimes:jpg,png,jpeg',
        ]);

        $data['user_id'] = auth()->user()->id;


        if($request->hasFile('image')) {
            $imageName = time() . '_transaction.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'banks');
            $data['image'] = 'Admin/images/banks/' .  $imageName;
        }

        BankTrnsaction::create($data);

        return to_route('banktransactions.index', $request->bank_id)->with('success', __('alerts.added_successfully'));

        // return to_route('banktransaction.index', $request->bank_id)->with('error', __('main.bank_wallet_does_not_have_enough_amount'));
    }

    public function update(Request $request, $id)
    {
        $bankTransaction = BankTrnsaction::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:0,1',
            'image' => 'nullable|mimes:jpg,png,jpeg',
        ]);

        $data['user_id'] = auth()->user()->id;

        if($request->hasFile('image')) {
            $imageName = time() . '_transaction.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'banks', $bankTransaction->image);
            
            $data['image'] = 'Admin/images/banks/' .  $imageName;
        }

        $bankTransaction->update($data);

        return to_route('banktransactions.index', $bankTransaction->bank_id)->with('success', __('alerts.updated_successfully'));
    }


    public function destroy($id)
    {
        $shipment = BankTrnsaction::findOrFail($id);

        $shipment->delete();

        return response()->json(['staus' => true, 'msg' => __('alerts.deleted_successfully')], 200);
    }
}
