@extends("layouts.admin")
@section("content")
<div class="container">
    @include("layouts.includes.breadcrumb", [ 'page' => __('main.transportations') ])
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-toolbar">
                <!--begin::Button-->
                    @can('transportations.create')
                    <a href="{{ $route_create }}" class="btn btn-primary font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>{{ __('admin.add') }}
                    </a>
                    @endcan

{{--                    <div class="float-left ml-2">--}}
{{--                        <button type="button" class="btn btn-success " id="imports"  data-toggle="modal" data-target="#import_excels">--}}
{{--                            <i class="icon-share-alternitive"></i>--}}
{{--                            {{ __('admin.import') }}--}}
{{--                        </button>--}}
{{--                    </div>--}}
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm" id="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('main.container') }}</th>
                        <th scope="col">{{ __('main.company') }}</th>
                        <th scope="col">{{ __('admin.departure_location') }}</th>
                        <th scope="col">{{ __('admin.loading_location') }}</th>
                        <th scope="col">{{ __('admin.aging_location') }}</th>
                        <th scope="col">{{ __('admin.price') }}</th>
                        <th scope="col">{{ 'note' }}</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transportations as $transportation)
                        <tr>
                            <th scope="row">
                                {{$transportation->id}}
                            </th>
                            <td>
                                {{$transportation->company_name}}
                            </td>
                            <td>
                                {{$transportation->container_type ?? ''}}
                            </td>
                            <td>
                                {{$transportation->departure->title ?? ''}}
                            </td>
                            <td>
                                {{$transportation->loading->title ?? ''}}
                            </td>
                            <td>
                                {{$transportation->aging->title ?? ''}}
                            </td>
                            <td>
                                {{$transportation->price}}
                            </td>
                            <td>
                                @can('transportations.edit')
                                    <a href="{{route('companyTransportations.edit',[ 'companyTransportation' => $transportation->id, 'company_id' => ((isset(request()->company_id) && !is_null(request()->company_id)) ? request()->company_id : null) ])}}" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                @endcan
                                @can('transportations.destroy')
                                    <button class="btn btn-icon btn-light btn-hover-danger btn-sm delete" onclick="Delete('{{ $transportation->id }}')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--end::Card-->
</div>
@include('admin.transportations.modals.import')
@endsection
@push('js')
    <script>
        (function($) {
            "use strict";s
        })(jQuery);

        function Delete(id) {
            Swal.fire({
                title: "{{ __('alerts.are_you_sure') }}",
                text: "{{ __('alerts.not_revert_information') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('alerts.confirm') }}",
                cancelButtonText: "{{ __('alerts.cancel') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{ route("companyTransportations.destroy", ":id") }}';
                    url = url.replace(':id', id);
                    var token = '{{ csrf_token() }}';
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            location.reload();
                            Swal.fire({
                                title: {{ __('alerts.done') }},
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
