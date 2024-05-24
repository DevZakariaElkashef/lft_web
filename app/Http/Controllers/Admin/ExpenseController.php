<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Agent\StoreRequest;
use App\Http\Requests\Admin\Agent\UpdateRequest;
use App\Models\Agent;
use App\Models\LogActivity;
use App\Notifications\AssignAgentPasswordNotification;
use App\Notifications\AssignPasswordNotification;
use App\Services\PasswordResetAgentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ExpenseController extends Controller
{

    public function agent_expenses(Agent $agent)
    {
        $financial_custodies = collect();
        $expenses = collect();

        $financial_custodies = $agent->sended_financial_custodies()
            ->orderBy("id", "desc")
            ->get();
        $expenses = $agent->expenses()
            ->orderBy("id", "desc")
            ->get();

        $merged = $financial_custodies->concat($expenses);

        $ordered = $merged->sortBy('created_at')->values();
        $allExpenses = $ordered;
        return view('admin.agents.expenses.index', compact("allExpenses"));
    }



}
