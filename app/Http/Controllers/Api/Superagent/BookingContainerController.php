<?php

namespace App\Http\Controllers\Api\Superagent;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Superagent\BookingContainerResource;
use App\Http\Resources\Api\Superagent\BookingResource;
use App\Http\Resources\Api\Superagent\SpecificationBookingResource;
use App\Models\Booking;
use App\Models\BookingContainer;
use Illuminate\Http\Request;

class BookingContainerController extends Controller
{
    public function specification()
    {
        try {

//            $booking_containers = BookingContainer::whereStatus(0)->orderBy("id", "desc")->paginate(10);


            $bookings = Booking::whereHas("bookingContainers", function ($qc){
                    $qc->where("status", 0);
                })->orderBy("id", "desc")->paginate(10);

          //  $data = BookingContainerResource::collection($booking_containers)->response()->getData(true);

            $data = SpecificationBookingResource::collection($bookings)->response()->getData(true);
            //response

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function loading()
    {
        try {

            $booking_containers = BookingContainer::whereStatus(1)->orderBy("id", "desc")->paginate(10);


            $data = BookingContainerResource::collection($booking_containers)->response()->getData(true);

            //response

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $ex) {

            return $this->returnError(500, $ex->getMessage());
        }
    }

    public function unloading()
    {
        try {

            $booking_containers = BookingContainer::whereStatus(2)->orderBy("id", "desc")->paginate(10);


            $data = BookingContainerResource::collection($booking_containers)->response()->getData(true);

            //response

            return $this->returnAllData($data, __('alerts.success'));
        } catch (\Exception $ex) {


            return $this->returnError(500, $ex->getMessage());
        }
    }
}
