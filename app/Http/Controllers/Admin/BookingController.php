<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\BookingContainer;
use App\Models\BookingPaper;
use App\Models\Branch;
use App\Models\CitiesAndRegions;
use App\Models\Company;
use App\Models\Container;
use App\Models\Employee;
use App\Models\Factory;
use App\Models\ServiceCategory;
use App\Models\shippingAgent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:bookings.index')->only('index');
        $this->middleware('permission:bookings.create')->only(['create', 'store']);
        $this->middleware('permission:bookings.udpate')->only(['edit', 'udpate']);
        $this->middleware('permission:bookings.delete')->only('destroy');
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings  = Booking::query()
            ->filterDate(request('arrival_date'))
            ->filterSearch(request('search'))
            ->filterCompany(request('company'))
            // ->filterTaxStatus(request('tax_status'))
            ->get();
        $companies = Company::query()->get();
        return view('admin.bookings.index', compact('bookings', 'companies'));
    }

    private function getCreateFormInputs()
    {
        $companies = Company::whereHas('employees')
            ->with('employees')
            ->get();

        $company_employees = [];
        foreach ($companies as $company)
            foreach ($company->employees as $employee)
                $company_employees[$company->id][$employee->id] = $employee->name;
        return [
            'companies'         => $companies,
            'company_employees' => $company_employees,
            'shipping_agents'   => shippingAgent::pluck('title', 'id'),
            'type_of_actions'   => bookingActions(),
            'containers_type'   => Container::all()->pluck('full_name', 'id'),
            'factories'         => Factory::pluck('name', 'id'),
            'branches'          => Branch::pluck('name', 'id'),
            'employees'        => Employee::pluck('name', 'id'),

        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $input = array_merge(
            $this->getCreateFormInputs(),
            [
                'method'            => 'POST',
                'action'            => route('bookings.store'),
                'companies' => Company::all()
            ]
        );

        return view('admin.bookings.create', $input);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::create($request->only(
                'company_id',
                'employee_id',
                'shipping_agent_id',
                'booking_number',
                'certificate_number',
                'type_of_action',
                'discharge_date',
                'permit_end_date',
                'employee_name',
                'factory_id'
            ));
            
            $dataBookingContainers = [];
            
            foreach ($request->get('containers') as $container) {
                for ($i = 0; $i < $container['containers_count']; $i++) {
                    $dataBookingContainers[] = [
                        'booking_id'        => $booking->id,
                        'container_id'      => $container['container_id'],
                        'arrival_date'      => $container['arrival_date'],
                        'branch_id' => $container['branch_id']
                    ];
                }
            }
            BookingContainer::insert($dataBookingContainers);
            // for ($i = 0; $i < count($request->branches); $i++) {
            //     $dataBookingContainers = [
            //         'booking_id'        => $booking->id,
            //         'container_id'      => $request->containers[$i],
            //         'arrival_date'      => $request->arrival_dates[$i],
            //         'container_no'      => $request->container_no[$i],
            //         'sail_of_number'    => $request->sail_of_numbers[$i],
            //         'branch_id' => $request->branches[$i]
            //     ];
            //     BookingContainer::create($dataBookingContainers);
            // }

            DB::commit();
            if ($booking)
                return redirect()->route('bookings.index')->with(__('alerts.added_successfully'));
            else
                redirect()->back()->with('error', 'something went wrong');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            if (!$th->getMessage()) {
                redirect()->route('bookings.index')->with('error', $th->getResponse()?->getData());
            } elseif ($th->getMessage()) {
                redirect()->route('bookings.index')->with('error', $th->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {

        $input = [
            'booking'      => $booking,
            'containers'   => $booking->bookingContainers->mapWithKeys(function ($container) {
                return [
                    $container->container?->id => $container->container?->type,
                ];
            }),
            'classifications'   => ServiceCategory::pluck('title', 'id'),
            'citiesAndRegions'  => CitiesAndRegions::pluck('title', 'id'),
        ];

        return view('admin.bookings.show', $input);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $input = array_merge(
            $this->getCreateFormInputs(),
            [
                'employees' => $booking
                    ->company
                    ->employees
                    ->pluck('name', 'id'),
                'booking'   => $booking,
                'method'    => 'PUT',
                'action'    => route('bookings.update', $booking),
            ]
        );
        // dd($booking->type_of_action);
        // ['bookingContainer']
        // dd($input['booking']->bookingContainers);
        return view('admin.bookings.edit', $input);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            $booking->update($request->only(
                'company_id',
                'employee_id',
                'shipping_agent_id',
                'booking_number',
                'certificate_number',
                'type_of_action',
                'discharge_date',
                'permit_end_date',
                'factory_id',
                'employee_name'
            ));

            // $bookingContainersID = $booking->bookingContainers->pluck('id')->toArray();

            // BookingContainer::destroy($bookingContainersID);
            // for ($i = 0; $i < count($request->branches); $i++) {
            //     $dataBookingContainers = [
            //         'booking_id'        => $booking->id,
            //         'container_id'      => $request->containers[$i],
            //         'arrival_date'      => $request->arrival_dates[$i],
            //         'container_no'      => $request->container_no[$i],
            //         'sail_of_number'    => $request->sail_of_numbers[$i],
            //         'branch_id' => $request->branches[$i]
            //     ];
            //     BookingContainer::create($dataBookingContainers);
            // }
            // TODO: ANY INFORMATION RELATED TO THESE CONTAINERS WILL BE DESTROYED
            // LIKE THE LOADING, UNLOADING, PRICE, ...etc

            DB::commit();
            return redirect()->route('bookings.index')->with(__('alerts.updateed_successfully'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            if (!$th->getMessage()) {
                redirect()->route('bookings.index')->with('error', $th->getResponse()?->getData());
            } elseif ($th->getMessage()) {
                redirect()->route('bookings.index')->with('error', $th->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(['status' => true, 'msg' => __('alerts.deleted_successfully')], 200);
    }
    public function booking_papers(Booking $booking)
    {
        $booking_papers = BookingPaper::where('booking_id', $booking->id)->get();
        $input = [
            'booking'      => $booking,
            'booking_papers'   => $booking_papers,
        ];

        return view('admin.bookings.papers', $input);
    }
}