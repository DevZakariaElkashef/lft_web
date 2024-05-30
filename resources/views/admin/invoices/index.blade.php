@extends('layouts.admin')

@section('css')
@endsection

@section('content')
    <div class="container">
        @include('layouts.includes.breadcrumb', ['page' => __('main.Tax_invoices')])
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap  align-items-center py-5">
                <div class="card-toolbar">
                    <div class="">
                        <!--begin::Button-->
                        <a href="{{ route('bookings.create', request()->id) }}" class="btn btn-primary font-weight-bolder">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path
                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                            fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>{{ __('admin.add') }}
                        </a>
                    </div>

                    <!--end::Button-->
                </div>
                <div class="">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        {{ __('admin.filter') }}
                    </button>

                    <a href="{{ route('bookings.invoices.pdf') }}?ids={{ implode(',', $bookings->pluck('id')->toArray()) }}" class="btn btn-secondary">
                        {{ __("main.download_all_invoices") }}
                    </a>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.filter') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        X
                                    </button>
                                </div>
                                <form action="{{ route('bokkings.invoices', request()->id) }}" method="get">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="idSelect">{{ __('main.companies') }}</label>
                                                   <select class="form-control" name="id" id="idSelect">
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                    @endforeach
                                                   </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dateFrom">{{ __('admin.from') }}</label>
                                                    <input id="dateFrom" class="form-control" type="date"
                                                        name="date_from">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dateTo">{{ __('admin.to') }}</label>
                                                    <input id="dateTo" class="form-control" type="date"
                                                        name="date_to">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">{{ __('admin.filter') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-xl" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('admin.factory_name') }}</th>
                            <th scope="col">{{ __('admin.booking_number') }}</th>
                            <th scope="col">{{ __('main.date') }}</th>
                            <th scope="col">{{ __('admin.total') }}</th>
                            <th scope="col">{{ __('main.added_by') }}</th>
                            <th scope="col">{{ __('admin.addition') }}</th>

                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    {{ $booking->factory->name }}
                                </td>
                                <td>
                                    {{ $booking->booking_number }}
                                </td>
                                <td>
                                    {{ $booking->created_at }}
                                </td>
                                <td>
                                    {{ $booking->invoice ? $booking->invoice->invoice_total_after_tax : 0 }}
                                </td>
                                <td>
                                    {{ $booking->user ? $booking->user->name : '' }}
                                </td>

                                <td>
                                    <div class="row">
                                        <div class="col-md-3 mr-3">
                                            <a href="{{ route('booking-invoices.show', $booking->invoice->id) }}" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 ">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
        <!--end::Card-->
    </div>
@endsection
@push('js')
@endpush
