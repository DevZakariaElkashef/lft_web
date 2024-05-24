@extends("layouts.admin")
@section("content")
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                {{ __('admin.edit_factory_information') }}
            </div>
        </div>
        @include('admin.factories.form')
    </div>
@endsection
