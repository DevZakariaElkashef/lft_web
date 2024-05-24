<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyRequest;
use App\Models\Company;
use App\Notifications\AssignPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $input = [
            'companies' => Company::all(),
        ];
        return view('admin.companies.index', $input);
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
            'action'    => route('companies.store')
        ];

        return view('admin.companies.create', $input);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->all());
        $token = \JWTAuth::fromUser($company);
        $company->update(array_merge(['session_id' => $token]));
        Notification::send($company, new AssignPasswordNotification($company));

        return redirect()->route('companies.index')
            ->with('success', __('alerts.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $input = [
            'company'           => $company,
            'transportations'   => $company->transportations,
        ];
        return view('admin.companies.show', $input);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $input = [
            'method'    => 'PUT',
            'action'    => route('companies.update', $company->id),
            'company'   => $company,
        ];

        return view('admin.companies.edit', $input);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->all());
        return redirect()->route('companies.index')
            ->with('success', __('alerts.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(['staus' => true, 'msg' => __('alerts.deleted_successfully')], 200);
    }


    public function getEmployees(Company $company){
        return !is_null($company->employees) ? $company->employees->pluck('name', 'id') : null;
    }
}