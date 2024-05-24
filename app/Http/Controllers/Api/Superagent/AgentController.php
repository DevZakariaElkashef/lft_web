<?php

namespace App\Http\Controllers\Api\Superagent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Superagent\AgentRequest;
use App\Http\Requests\Api\Superagent\BookingAgentRequest;
use App\Http\Resources\Api\Superagent\AgentResource;
use App\Http\Resources\Api\Superagent\SimpleBookingContainerResource;
use App\Models\Agent;
use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\BookingContainer;
use App\Services\SaveNotification;
use App\Services\SendNotification;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function fetch_agents()
    {
        try {

            $agents = Agent::orderBy("id", "desc")->ofFilter()->get();


            $data = AgentResource::collection($agents);

            //response

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }
    public function assign_agents(AgentRequest $request)
    {
        try {

            $superagent = auth()->guard("superagent")->user();
            $booking_container = BookingContainer::whereId($request->booking_container_id)->first();

            // $booking_container->agents()->attach($request->agent_ids,["booking_container_status" => $booking_container->status]);

            $agent_ids = $request->agent_ids ?? [];

            $booking_container->agents()
                ->whereNotIn('agent_id', $agent_ids)
                ->detach();
            $booking_container->agents()->wherePivot('booking_container_status', '=', $booking_container->status)->detach($agent_ids);
            $booking_container->agents()->attach($agent_ids,["booking_container_status" => $booking_container->status]);


            $data = new SimpleBookingContainerResource($booking_container);

            foreach($booking_container->agents as $agent) {
                $title = "new Notification";
                $text = "A booking container has been assigned by $superagent->name to $agent->name";

                SaveNotification::create($title, $text, $agent->id, Agent::class, AppNotification::specific);
                SendNotification::send($agent->device_token ?? "", $title, $text);

            }
            //response

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
}

    public function assign_specification_booking(BookingAgentRequest $request)
    {
        try {

            $superagent = auth()->guard("superagent")->user();
            $booking = Booking::whereId($request->booking_id)->first();

            $booking_containers = $booking->bookingContainers()->where("booking_containers.status",0)->get();

            $agents = Agent::whereIn("id",$request->agent_ids)->get();

            foreach ($booking_containers as $booking_container) {
                $booking_container->agents()->wherePivot('booking_container_status', '=', $booking_container->status)->detach($request->agent_ids);
                $booking_container->agents()->attach($request->agent_ids, ["booking_container_status" => $booking_container->status]);

            }
            foreach($agents as $agent) {
                $title = "new Notification";
                $text = "A booking  has been assigned by $superagent->name to $agent->name";

                SaveNotification::create($title, $text, $agent->id, Agent::class, AppNotification::specific);
                SendNotification::send($agent->device_token ?? "", $title, $text);

            }
            //response

            return $this->returnResponseSuccessMessage( __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }
}
