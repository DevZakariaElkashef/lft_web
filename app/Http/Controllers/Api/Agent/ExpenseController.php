<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Agent\GeneralExpenseRequest;
use App\Http\Requests\Api\Agent\ReservationExpenseRequest;
use App\Http\Resources\Api\Agent\ExpenseResource;
use App\Models\Agent;
use App\Models\AgentExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExpenseController extends Controller
{
    public function fetch_financial_custody()
    {
        try {

            $agent = auth()->guard('agent')->user();


            $total_financial_custody  = $agent->total_financial_custody;
            $spented_financial_custody  = $agent->spented_financial_custody;
            $remaining_financial_custody  = $agent->remaining_financial_custody;

            //reponse
            $data["total_financial_custody"] = $total_financial_custody;
            $data["spented_financial_custody"] = $spented_financial_custody;
            $data["remaining_financial_custody"] = $remaining_financial_custody;

            return $this->returnAllData((object) $data, __('alerts.success'));
        } catch (\Exception $Exception) {
            return $this->returnError(401, $Exception->getMessage());
        }
    }
    public function make_general_expenses(GeneralExpenseRequest $request)
    {
        try {

            $agent = auth()->guard('agent')->user();

            if ($agent->remaining_financial_custody < $request->financial_custody) {
                return $this->returnError(200, __('main.you dont have enougth money'));
            }
            $data = $request->validated();
            $data["agent_id"] = $agent->id;
            $data["type"] = 1;
            $expense =  AgentExpense::create($data);

            $this->saveLogActivity($agent->id, Agent::class, $expense->id, AgentExpense::class);


            return $this->returnResponseSuccessMessage(200, __('alerts.Expense saved successfully'));
        } catch (\Exception $Exception) {
            return $this->returnError(401, $Exception->getMessage());
        }
    }
    public function make_reservation_expenses(ReservationExpenseRequest $request)
    {
        try {

            $agent = auth()->guard('agent')->user();

            if ($agent->remaining_financial_custody < $request->financial_custody) {
                return $this->returnError(200, __('main.you dont have enougth money'));
            }
            $data = $request->validated();
            $data["agent_id"] = $agent->id;
            $data["type"] = 2;
            $expense = AgentExpense::create($data);

            $this->saveLogActivity($agent->id, Agent::class, $expense->id, AgentExpense::class);

            return $this->returnResponseSuccessMessage(200, __('alerts.Expense saved successfully'));
        } catch (\Exception $Exception) {
            return $this->returnError(401, $Exception->getMessage());
        }
    }
    public function fetch_all_expenses()
    {
        try {
            $type = request()->type;
            $agent = auth()->guard('agent')->user();
            $financial_custodies = collect();
            $expenses = collect();

            if ($type == 1) {
                $financial_custodies = $agent->sended_financial_custodies()
                    ->where("delivery_policy_id", "!=", null)
                    ->whereDate("created_at", now())
                    ->get();
                $expenses = $agent->expenses()
                    ->whereDate("created_at", now())
                    ->where("delivery_policy_id", "!=", null)
                    ->get();
            } elseif ($type == 2) {
                $expenses = $agent->expenses()
                    ->whereDate("created_at", now())
                    ->where("type", 2)
                    ->get();
            } elseif (request()->booking_id) {
                $expenses = $agent->expenses()
                    ->where("booking_id", request()->booking_id)
                    ->get();
            } elseif (request()->delivery_policy_id) {
                $expenses = $agent->expenses()
                    ->where("delivery_policy_id", request()->delivery_policy_id)
                    ->get();
            } else {
                $financial_custodies = $agent->sended_financial_custodies()
                    ->whereDate("created_at", now())
                    ->get();
                $expenses = $agent->expenses()
                    ->whereDate("created_at", now())
                    ->get();
            }

            $merged = $financial_custodies->concat($expenses);

            $ordered = $merged->sortBy('created_at')->values();

            $data = ExpenseResource::collection($ordered);

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $exception) {
            return $this->returnError(401, $exception->getMessage());
        }
    }
    public function fetch_latest_expenses()
    {
        try {

            $agent = auth()->guard('agent')->user();

            $financial_custodies = $agent->sended_financial_custodies()->whereDate("created_at", now())->get();
            $expenses = $agent->expenses()->whereDate("created_at", now())->get();

            // Merge the collections
            $merged = $financial_custodies->concat($expenses);

            // Order the merged collection by the created_at timestamp
            $ordered = $merged->sortBy('created_at')->take(3);

            $data = ExpenseResource::collection($ordered);

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $Exception) {
            return $this->returnError(401, $Exception->getMessage());
        }
    }
}
