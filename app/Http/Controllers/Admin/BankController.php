<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use App\Exports\BankExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bank.index')->only('index');
        $this->middleware('permission:bank.create')->only(['create', 'store']);
        $this->middleware('permission:bank.udpate')->only(['edit', 'udpate']);
        $this->middleware('permission:bank.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banks = Bank::query();

        if ($request->filled('date_from')) {
            $banks->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $banks->whereDate('created_at', '<=', $request->date_to);
        }

        $banks = $banks->get();

        return view('admin.banks.index', compact('banks'));
    }



    public function export(Request $request)
    {
        $ids = explode(',', $request->ids);
        return Excel::download(new BankExport($ids), 'bank.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $input = [
            'method'    => 'POST',
            'action'    => route('banks.store')
        ];

        return view('admin.banks.create', $input);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
            'type' => 'required|in:0,1'
        ]);

        Bank::create($request->all());

        return redirect()->route('banks.index')
            ->with('success', __('alerts.added_successfully'));
    }


    public function edit(Bank $bank)
    {
        $input = [
            'method'    => 'PUT',
            'action'    => route('banks.update', $bank->id),
            'bank'   => $bank,
        ];

        return view('admin.banks.edit', $input);
    }


    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
            'type' => 'required|in:0,1'
        ]);

        // Find the bank transaction
        $transaction = Bank::findOrFail($id);

        // Update the transaction
        $transaction->update($request->all());

        return back()->with('success', __('main.transaction_updated_successfully'));
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return response()->json(['staus' => true, 'msg' => __('alerts.deleted_successfully')], 200);
    }
}
