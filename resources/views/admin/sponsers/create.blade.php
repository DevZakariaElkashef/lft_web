@extends("layouts.admin")
@section("content")
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                {{ __('admin.add_new_sponser') }}
            </div>
        </div>
        @include('admin.sponsers.form')
    </div>
@endsection
