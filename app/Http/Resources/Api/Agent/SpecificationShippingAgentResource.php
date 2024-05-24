<?php

namespace App\Http\Resources\Api\Agent;

use App\Http\Resources\Api\Superagent\BookingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecificationShippingAgentResource extends JsonResource
{

    public function toArray($request)
     {
    //     $bookingContainers = collect();

    //      $agent = auth()->guard('agent')->user();

    //     $agent_booking_container_ids = $agent->agent_booking_containers()->wherePivot("created_at", ">=", now()->startOfDay())
    //         ->wherePivot("created_at", "<=", now()->endOfDay())->wherePivot("booking_container_status", 0)->get()->pluck("id")->toArray();

    //       $bookingContainers = $this->bookingContainers()->whereIn("booking_containers.id", $agent_booking_container_ids)->get();

        return [
            "id" => $this->id,
            "title" => $this->title ?? "",
            "bookings" =>  SpecificationBookingResource::collection(
                $this->bookings()->
                whereHas("bookingContainers",function($q){
                    $q->where("booking_containers.status",0);
                })
                    ->get()
            )
//            "booking_containers" =>  BookingContainerResource::collection($bookingContainers)

        ];
    }
}
