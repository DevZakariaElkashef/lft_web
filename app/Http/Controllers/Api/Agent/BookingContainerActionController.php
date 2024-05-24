<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Agent\BookingContainerRequest;
use App\Http\Requests\Api\Agent\BookingRequest;
use App\Http\Requests\Api\Agent\NoteRequest;
use App\Http\Resources\Api\Agent\BookingContainerResource;
use App\Http\Resources\Api\Agent\NoteResource;
use App\Models\Agent;
use App\Models\AgentExpense;
use App\Models\AppNotification;
use App\Models\Booking;
use App\Models\BookingContainer;
use App\Models\BookingContainerAgent;
use App\Models\DailyBookingContainer;
use App\Models\Image;
use App\Models\Note;
use App\Services\SaveNotification;
use App\Services\SendNotification;
use Illuminate\Http\Request;

class BookingContainerActionController extends Controller
{
    public function done_specification(BookingRequest $request)
    {
        try {


            $agent = auth()->guard("agent")->user();
            $booking = Booking::whereId($request->booking_id)->first();

           $booking_container_ids =  $booking->bookingContainers()->where("booking_containers.status",0)->pluck("id")->toArray();
            $booking->bookingContainers()->where("booking_containers.status",0)->update([
                "status" => 1
            ]);


            BookingContainerAgent::where("booking_container_status",0)->whereIn("booking_container_id",$booking_container_ids)->whereAgentId($agent->id)->update([
                "booking_container_status" => 1
            ]);

            $title = "new Notification";
            $text ="booking No. $booking->booking_number  was specification by $agent->name";

            SaveNotification::create($title, $text, null, null,AppNotification::all);
            SendNotification::send($agent->device_token ?? "", $title, $text);

//            $this->saveLogActivity(auth()->guard("agent")->user()->id,Agent::class, $booking->id,Booking::class,$booking->status);

            //response

            return $this->returnSuccessMessage(__('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function done_loading(BookingContainerRequest $request)
    {
        try {

            $agent = auth()->guard("agent")->user();
            $booking_container = BookingContainer::whereId($request->booking_container_id)->first();


            $booking_container->update([
                "status" => 2
            ]);
            BookingContainerAgent::whereBookingContainerId($booking_container->id)->whereAgentId($agent->id)->update([
                "booking_container_status" => 2
            ]);
            $data = new BookingContainerResource($booking_container);

            $title = "new Notification";
            $text ="Container No. $booking_container->container_no  was loaded by $agent->name";

            SaveNotification::create($title, $text, null, null,AppNotification::all);
            SendNotification::send($agent->device_token ?? "", $title, $text);

            $this->saveLogActivity(auth()->guard("agent")->user()->id,Agent::class, $booking_container->id,BookingContainer::class,$booking_container->status);

            //response

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function done_unloading(BookingContainerRequest $request)
    {
        try {

            $agent = auth()->guard("agent")->user();
            $booking_container = BookingContainer::whereId($request->booking_container_id)->first();


            $booking_container->update([
                "status" => 3
            ]);

            BookingContainerAgent::whereBookingContainerId($booking_container->id)->whereAgentId($agent->id)->update([
                "booking_container_status" => 3
            ]);
            $data = new BookingContainerResource($booking_container);

            $title = "new Notification";
            $text ="Container No. $booking_container->container_no  was unloaded by $agent->name";

            SaveNotification::create($title, $text, null, null,AppNotification::all);
            SendNotification::send($agent->device_token ?? "", $title, $text);

            $this->saveLogActivity(auth()->guard("agent")->user()->id,Agent::class, $booking_container->id,BookingContainer::class,$booking_container->status);

            //response

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }
    public function send_notes(NoteRequest $request)
    {
        try {

            $booking_container = BookingContainer::whereId($request->booking_container_id)->first();


            $data["attacher_id"] = auth()->guard("agent")->id();
            $data["attacher_type"] = "App\Models\Agent";
            $data["attached_id"] = $booking_container->id;
            $data["attached_type"] = "App\Models\BookingContainer";
            $data["notes"] = $request->notes;

            $note = Note::create($data);

            if ($request->images && count($request->images) > 0) {
                foreach ($request->images as $image) {
                    $image_data["image"] = $image;
                    $image_data["imageable_id"] = $note->id;
                    $image_data["imageable_type"] = "App\Models\Note";
                    Image::create($image_data);
                }
            }
            $response = new NoteResource($note);

            //response

            return $this->returnAllData($response, __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }
}
