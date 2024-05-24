@extends("layouts.admin")
@section("content")
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                {{ __('admin.add_new_driver') }}
            </div>
        </div>
        @include('admin.drivers.form')
    </div>
@endsection
