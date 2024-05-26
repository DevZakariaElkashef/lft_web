<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentCarTranferController extends Controller
{
    public function index($id)
    {
        $agent = Agent::findOrFail($id);

        return view('admin.agents_car_tranfer.index', compact('agent'));
    }
}
