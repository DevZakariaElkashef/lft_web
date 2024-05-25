@extends('layouts.admin')
@php
    $from = isset($_GET['from']) ? $_GET['from'] : '';
@endphp

@section('content')
    <div class="container">
        @include('layouts.includes.breadcrumb', ['page' => $company->name])
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <div class="card-toolbar">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('createcompanyInvoices', $company->id) }}"
                                class="btn btn-primary font-weight-bolder">
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
                        <div class="col-md-4">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalDefault"
                                class="btn btn-primary font-weight-bolder">
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
                                </span>فلتر
                            </button>
                        </div>
                        <!--end::Button-->
                    </div>
                    <!--begin::Button-->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table" id="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">صورة التحويل</th>
                                <th scope="col">قيمة التحويل</th>
                                <th scope="col">من قام بالاضافة</th>

                                <th scope="col">{{ __('admin.created_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <th scope="row">{{ $invoice->id }}</th>
                                    <td>
                                        <a href="{{ asset('Admin/images/companyInvoice/' . $invoice->image) }}"
                                            download><img class="bg-soft-primary rounded img-fluid avatar-40 me-3"
                                                style="width:100px;height:100px"
                                                src="{{ asset('Admin/images/companyInvoice/' . $invoice->image) }}"
                                                alt="Ads"></a>
                                    </td>
                                    <td>
                                        {{ $invoice->total }}
                                    </td>
                                    <td>
                                        {{ $invoice->user->name }}
                                    </td>

                                    <td>{{ $invoice->created_at }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <div class="modal fade" id="exampleModalDefault" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        فلتر ب فترة زمنية
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">

                        <form id="submit-form1" class="was-validated" action="{{ route('filtercompanyInvoices') }}"
                            method="get">
                            <input type="hidden" name="company_id" value="{{ $company->id }}">
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">
                                    من
                                </label>
                                <input class="form-control is-invalid" id="validationTextarea" placeholder="من"
                                    name="from" type="date" required>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">الي</label>
                                <input class="form-control is-invalid" id="validationTextarea" placeholder="من"
                                    name="to" type="date" required>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                    <button form="submit-form1" type="submit" class="btn btn-primary">فلتر</button>
                </div>
            </div>
        </div>
    </div>
@endsection
